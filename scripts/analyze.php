<?php

require __DIR__ . '/../vendor/autoload.php';

function classChain(ReflectionClass $class)
{
    $chain = [];
    do {
        array_unshift($chain, $class->getName());
    } while ($class = $class->getParentClass());

    return $chain;
}

function childExceptions(array $parent, array $exceptions)
{
    $count = count($parent);
    $children = [];
    $tmp = [];
    foreach ($exceptions as $exception) {
        if ($count >= count($exception)) {
            continue;
        }

        $copy = $exception;
        $prefix = array_slice($copy, 0, $count);
        $copy = array_slice($copy, $count);
        if ($parent == $prefix && count($copy) == 1) {
            $children[] = $exception;
        } else {
            $tmp[] = $exception;
        }
    }

    return [$children, $tmp];
}

function subExceptions(array $parent, array $exceptions)
{
    $count = count($parent);
    $subExceptions = [];

    foreach ($exceptions as $exception) {
        if ($count >= count($exception)) {
            continue;
        }

        $copy = $exception;
        $prefix = array_slice($copy, 0, $count);
        if ($parent == $prefix) {
            $subExceptions[] = $exception;
        }
    }

    return $subExceptions;
}

function tree(array $parent, array $subExceptions)
{
    if (empty($parent) || empty($subExceptions)) {
        return [];
    }

    $result = [];
    [$children, $subExceptions] = childExceptions($parent, $subExceptions);

    foreach ($children as $child) {
        $sub = subExceptions($child, $subExceptions);
        if (!empty($sub)) {
            $result[end($child)] = tree($child, $sub);
        } else {
            $result[end($child)] = [];
        }
    }

    return $result;
}


$classes = [
    'yii\di\NotInstantiableException',
    'yii\web\HeadersAlreadySentException',
    'yii\web\TooManyRequestsHttpException',
    'yii\web\ConflictHttpException',
    'yii\web\UrlNormalizerRedirectException',
    'yii\web\RangeNotSatisfiableHttpException',
    'yii\web\ServerErrorHttpException',
    'yii\web\HttpException',
    'yii\web\UnauthorizedHttpException',
    'yii\web\UnprocessableEntityHttpException',
    'yii\web\GoneHttpException',
    'yii\web\UnsupportedMediaTypeHttpException',
    'yii\web\BadRequestHttpException',
    'yii\web\NotAcceptableHttpException',
    'yii\web\ForbiddenHttpException',
    'yii\web\NotFoundHttpException',
    'yii\web\MethodNotAllowedHttpException',
    'yii\db\IntegrityException',
    'yii\db\StaleObjectException',
    'yii\db\Exception',
    'yii\log\LogRuntimeException',
    'yii\base\ErrorException',
    'yii\base\UnknownPropertyException',
    'yii\base\ViewNotFoundException',
    'yii\base\InvalidParamException',
    'yii\base\UnknownMethodException',
    'yii\base\UnknownClassException',
    'yii\base\InvalidRouteException',
    'yii\base\InvalidValueException',
    'yii\base\InvalidArgumentException',
    'yii\base\InvalidConfigException',
    'yii\base\NotSupportedException',
    'yii\base\ExitException',
    'yii\base\Exception',
    'yii\base\InvalidCallException',
    'yii\base\UserException',
    'yii\console\UnknownCommandException',
    'yii\console\Exception',
    'BadFunctionCallException',
    'BadMethodCallException',
    'DomainException',
    'InvalidArgumentException',
    'LengthException',
    'LogicException',
    'OutOfBoundsException',
    'OutOfRangeException',
    'OverflowException',
    'RangeException',
    'RuntimeException',
    'UnderflowException',
    'UnexpectedValueException',
    'ErrorException',
];

$exceptions = [];
foreach ($classes as $class) {
    if ($class == 'yii\base\Object') {
        continue;
    }

    $ref = new ReflectionClass($class);
    if ($ref->isSubclassOf(\Exception::class)) {
        $exceptions[] = classChain($ref);
    }
}

$tree = tree(['Exception'], $exceptions);
echo "<?php\nreturn " . str_replace('\\\\', '\\', \yii\helpers\VarDumper::export(['Exception' => $tree])) . ';';
