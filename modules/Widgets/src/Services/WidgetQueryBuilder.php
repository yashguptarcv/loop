<?php

namespace Modules\Widgets\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WidgetQueryBuilder
{
    /**
     * Very small whitelist layer: checks table/column names against INFORMATION_SCHEMA to avoid injection.
     */
    public static function validateIdentifier(string $identifier): bool
    {
        // allow dotted identifiers like "orders.created_at"
        foreach (explode('.', $identifier) as $part) {
            if (!preg_match('/^[A-Za-z0-9_]+$/', $part)) return false;
        }
        return true;
    }

    public static function listTables(): array
    {
        $db = config('database.connections.' . config('database.default') . '.database');
        $rows = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = ?', [$db]);

        return array_map(fn($r) => $r->TABLE_NAME, $rows);
    }

    public static function listColumns(string $table): array
    {
        if (!self::validateIdentifier($table)) return [];
        $db = config('database.connections.' . config('database.default') . '.database');
        $rows = DB::select('SELECT column_name FROM information_schema.columns WHERE table_schema = ? AND table_name = ?', [$db, $table]);
        return array_map(fn($r) => $r->column_name, $rows);
    }

    public static function base(string $table)
    {
        if (!self::validateIdentifier($table)) abort(422, 'Invalid table');
        return DB::table($table);
    }

    public static function applyJoins($query, ?array $joins)
    {
        if (!$joins) return $query;

        foreach ($joins as $join) {
            $type = strtolower($join['type'] ?? 'inner');
            $method = match ($type) {
                'left'  => 'leftJoin',
                'right' => 'rightJoin',
                default => 'join',
            };

            $table = $join['table'] ?? null;
            $local = $join['local_column'] ?? null;
            $foreign = $join['foreign_column'] ?? null;

            foreach ([$table, $local, $foreign] as $id) {
                if (!$id || !self::validateIdentifier($id)) abort(422, 'Invalid join config');
            }

            $query->$method($table, DB::raw($local), '=', DB::raw($foreign));
        }

        return $query;
    }

    public static function applyConditions($query, ?array $conditions)
    {
        if (!$conditions) return $query;

        foreach ($conditions as $cond) {
            $column   = $cond['column']   ?? null;
            $operator = strtolower($cond['operator'] ?? '=');
            $value    = $cond['value']    ?? null;

            if (!$column) {
                continue; // skip invalid condition
            }

            switch ($operator) {
                case 'between':
                    if (is_array($value) && count($value) === 2) {
                        $query->whereBetween($column, $value);
                    }
                    break;

                case 'in':
                    $query->whereIn($column, (array) $value);
                    break;

                case 'not in':
                    $query->whereNotIn($column, (array) $value);
                    break;

                case 'null':
                    $query->whereNull($column);
                    break;

                case 'not null':
                    $query->whereNotNull($column);
                    break;

                default:
                    $query->where($column, strtoupper($operator), $value);
                    break;
            }
        }

        return $query;
    }


    public static function applyDateFilter($query, ?string $dateColumn, string $filter, $from, $to)
    {
        if (!$dateColumn || !self::validateIdentifier($dateColumn)) return $query;

        return match ($filter) {
            'today' => $query->whereDate(DB::raw($dateColumn), now()->toDateString()),
            'week'  => $query->whereBetween(DB::raw($dateColumn), [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereBetween(DB::raw($dateColumn), [now()->startOfMonth(), now()->endOfMonth()]),
            'year'  => $query->whereBetween(DB::raw($dateColumn), [now()->startOfYear(), now()->endOfYear()]),
            'custom' => $from && $to ? $query->whereBetween(DB::raw($dateColumn), [$from, $to]) : $query,
            default => $query,
        };
    }
}
