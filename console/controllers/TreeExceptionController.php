<?php

namespace console\controllers;

use PBergman\TreeHelper;
use ReflectionClass;
use yii\console\Controller;
use yii\console\ExitCode;

class TreeExceptionController extends Controller
{
    public function actionIndex()
    {
        $exceptions = $this->exceptions();
        $tree = $this->tree(array_merge($this->standExceptions(), $exceptions));
        $tree = $this->normalize($tree);
        TreeHelper::Format($tree);

        return ExitCode::OK;
    }

    private function standExceptions()
    {
        return [
            'Exception',
            'ErrorException',
            'Error',
            'ParseError',
            'TypeError',
            'ArgumentCountError',
            'ArithmeticError',
            'DivisionByZeroError',
            'LogicException',
            'BadFunctionCallException',
            'BadMethodCallException',
            'DomainException',
            'InvalidArgumentException',
            'LengthException',
            'OutOfRangeException',
            'RuntimeException',
            'OutOfBoundsException',
            'OverflowException',
            'RangeException',
            'UnderflowException',
            'UnexpectedValueException',
            'AssertionError',
            'PDOException',

        ];
    }

    private function normalize($data)
    {
        $resultMap = [];
        $resultList = [];
        foreach ($data as $key => $val) {
            if (!empty($val)) {
                $resultMap[$key] = $this->normalize($val);
            } else {
                $resultList[] = $key;
            }
        }

        return array_merge($resultList, $resultMap);
    }

    private function tree($exceptions)
    {
        $nodes = [];
        foreach ($exceptions as $exception) {
            $currentNodes = &$nodes;
            $parents = $this->parents($exception);
            foreach ($parents as $parent) {
                if (!isset($currentNodes[$parent])) {
                    $currentNodes[$parent] = [];
                }
                $currentNodes = &$currentNodes[$parent];
            }
        }

        return $nodes;
    }

    private function exceptions()
    {
        $classes = include YII2_PATH . '/classes.php';
        $exceptions = [];
        foreach ($classes as $class => $path) {
            if ($class === 'yii\base\Object') {
                continue;
            }

            /** @noinspection PhpUnhandledExceptionInspection */
            $ref = new ReflectionClass($class);
            if ($ref->isSubclassOf('Throwable')) {
                $exceptions[] = $class;
            }
        }

        return $exceptions;
    }

    private function parents(string $class)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $ref = new ReflectionClass($class);
        $classes = [$class];
        while ($ref = $ref->getParentClass()) {
            $classes[] = $ref->getName();
        }

        return array_reverse($classes);
    }
}
