<?php

namespace Joiner\ML;

use Phpml\Metric\ClassificationReport;

/**
 * Class Accuracy
 * @package Joiner\ML
 */
class Accuracy
{
    /**
     * @param $actualLabels
     * @param $predictedLabels
     * @return array
     * @throws \Phpml\Exception\InvalidArgumentException
     */
    public static function calc($actualLabels, $predictedLabels): array
    {
        $report = new ClassificationReport($actualLabels, $predictedLabels);
        return $report->getSupport();
    }
}
