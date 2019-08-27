<?php
/**
 * @author    Philip Bergman <pbergman@live.nl>
 * @copyright Philip Bergman
 */
namespace PBergman;

/**
 * Class TreeHelper
 *
 * a helper class to build a tree in a fluent way.
 *
 * the output is similar as the tree command in linux.
 *
 *
 * @package PBergman\Bundle\AdAlertBundle\Helper
 */
class TreeHelper
{
    /** @var  string */
    protected static $linePrefixEmpty = '    ';
    /** @var  string */
    protected static $linePrefix = '│   ';
    /** @var  string */
    protected static $textPrefix = '├── ';
    /** @var  string */
    protected static $textPrefixEnd = '└── ';

    const LINE_PREFIX_EMPTY = 1;
    const LINE_PREFIX = 2;
    const TEXT_PREFIX = 3;
    const TEXT_PREFIX_END = 4;

    /**
     * Static function to print direct a array
     *
     * @param array $data
     * @param array $formats
     * @param int|null $maxDepth
     */
    public static function Format(array $data, array $formats = [], $maxDepth = null)
    {
        $format = array_replace([
            self::LINE_PREFIX_EMPTY => self::$linePrefixEmpty,
            self::LINE_PREFIX => self::$linePrefix,
            self::TEXT_PREFIX => self::$textPrefix,
            self::TEXT_PREFIX_END => self::$textPrefixEnd,
        ], $formats);

        self::write('.');
        self::write('│');
        self::render($data, $format, '', $maxDepth);
        self::write('');
    }

    /**
     * internal function to print the tree recursive
     *
     * @param array $data
     * @param array $format
     * @param string $prefix
     * @param null $maxDepth
     * @param int $depth
     * @internal
     */
    protected static function render(array $data, array $format, $prefix = '', $maxDepth = null, $depth = 0)
    {
        if (!is_null($maxDepth) && $maxDepth <= $depth) {
            return;
        }
        foreach ($data as $index => $line) {
            if (self::isLast($data, $index)) {
                $titlePrefix = $prefix . $format[self::TEXT_PREFIX_END];
                $dataPrefix = $prefix . $format[self::LINE_PREFIX_EMPTY];
            } else {
                $titlePrefix = $prefix . $format[self::TEXT_PREFIX];
                $dataPrefix = $prefix . $format[self::LINE_PREFIX];;
            }
            if (preg_match('#^[0-9a-f]+@(?P<title>.+)$#i', $index, $m)) {
                $index = $m['title'];
            }
            switch (gettype($line)) {
                case 'boolean':
                case 'integer':
                case 'double':
                case 'string':
                case 'NULL':
                    self::write(sprintf('%s%s', $titlePrefix, $line));
                    break;
                case 'array':
                    self::write(sprintf('%s%s', $titlePrefix, $index));
                    self::render($line, $format, $dataPrefix, $maxDepth, ++$depth);
                    break;
                case 'object':
                    if (method_exists($line, '__toString')) {
                        self::write(sprintf('%s%s', $titlePrefix, (string) $line));
                    } else {
                        throw new InvalidArgumentException(sprintf('Given object should implement a __toString for class %s', get_class($line)));
                    }
                    break;
                case 'resource':
                    if (get_resource_type($line) === 'stream') {
                        rewind($line);
                        self::write(sprintf('%s%s', $titlePrefix, stream_get_contents($line)));
                    } else {
                        throw new InvalidArgumentException(sprintf('Only supporting streams as resource, given: %s', get_resource_type($line)));
                    }
                    break;
                default:
                    throw new InvalidArgumentException(sprintf('Unsupported type: %s', gettype($line)));
            }
        }
    }

    /**
     * helper function to get last key of array this can be
     * used to determine if we are last in a foreach loop
     *
     * @param   array $data
     * @return  mixed
     */
    public static function lastKey(array $data)
    {
        $keys = array_keys($data);
        return end($keys);
    }

    /**
     * check if current key is last in stack
     *
     * @param   array $data
     * @param   $key
     * @return  bool
     */
    public static function isLast(array $data, $key)
    {
        return  self::lastKey($data) === $key;
    }

    /**
     * will print message if output is set
     *
     * @param $message
     */
    protected static function write($message)
    {
        echo $message, "\n";
    }
}
