<?php

namespace Modules\DataView\ColumnTypes;

use Modules\DataView\Column;
use Modules\DataView\Enums\DateRangeOptionEnum;
use Modules\DataView\Enums\FilterTypeEnum;
use Modules\DataView\Exceptions\InvalidColumnException;
use Modules\DataView\Exceptions\InvalidColumnExpressionException;

class Datetime extends Column
{
    /**
     * Set filterable type.
     */
    public function setFilterableType(?string $filterableType): void
    {
        if (
            $filterableType
            && ($filterableType !== FilterTypeEnum::DATETIME_RANGE->value)
        ) {
            throw new InvalidColumnException('Datetime filters will only work with `datetime_range` type. Either remove the `filterable_type` or set it to `datetime_range`.');
        }

        parent::setFilterableType($filterableType);
    }

    /**
     * Set filterable options.
     */
    public function setFilterableOptions(mixed $filterableOptions): void
    {
        if (empty($filterableOptions)) {
            $filterableOptions = DateRangeOptionEnum::options();
        }

        parent::setFilterableOptions($filterableOptions);
    }

    /**
     * Process filter.
     */
    public function processFilter($queryBuilder, $requestedDates)
    {
        return $queryBuilder->where(function ($scopeQueryBuilder) use ($requestedDates) {
            if (is_string($requestedDates)) {
                $rangeOption = collect($this->filterableOptions)->firstWhere('name', $requestedDates);

                $requestedDates = ! $rangeOption
                    ? [[$requestedDates, $requestedDates]]
                    : [[$rangeOption['from'], $rangeOption['to']]];

                foreach ($requestedDates as $value) {
                    $scopeQueryBuilder->whereBetween($this->columnName, [
                        $value[0],
                        $value[1],
                    ]);
                }
            } elseif (is_array($requestedDates)) {
                foreach ($requestedDates as $value) {
                    $scopeQueryBuilder->whereBetween($this->columnName, [$value[0] ?? '', $value[1] ?? '']);
                }
            } else {
                throw new InvalidColumnExpressionException('Only string and array are allowed for datetime column type.');
            }
        });
    }
}
