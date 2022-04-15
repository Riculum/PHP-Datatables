<?php
namespace Datatables\core;

use Database\Core\Database as DB;
use PDO;

class Datatable {
    static function getDatatable(string $table, array $columns, array $where = []): string
    {
        $whereSelect = "";
        $whereClause = [];
        $queryColumns = implode(',', $columns);
        $query = "SELECT $queryColumns FROM $table";
        $queryTotal = "SELECT $queryColumns FROM $table";

        if (isset($_GET['search']['value'])) {
            for ($i = 0; $i < count($columns); $i++) {
                $whereClause[] = $_GET['search']['value'] . '%';
                if ($i === count($columns) - 1) {
                    $whereSelect .= $columns[$i] . ' LIKE ?';
                } else {
                    $whereSelect .= $columns[$i] . ' LIKE ? OR ';
                }
            }
            $query .= " WHERE ($whereSelect)";
            $queryTotal .= " WHERE ($whereSelect)";
        }

        if (!empty($where)) {
            if (count($where) == count($where, COUNT_RECURSIVE)) {
                $whereSelect = $where['key'] . " " . $where['operator'] . ' ?';
                $whereClause[] = $where['value'];
            } else {
                foreach ($where as $condition) {
                    $whereSelect .= $condition['key'] . " " . $condition['operator'] . " :" . $condition['key'] . " " . $condition['condition'] . " ";
                    $whereClause[] = $condition['value'];
                }
            }

            if (isset($_GET['search']['value'])) {
                $query .= " AND ($whereSelect)";
                $queryTotal .= " AND ($whereSelect)";
            } else {
                $query .= " WHERE $whereSelect";
                $queryTotal .= " WHERE $whereSelect";
            }
        }

        if (isset($_GET['order'])) {
            $orderColumn = $columns[$_GET['order']['0']['column']];
            $query .= " ORDER BY " . $orderColumn. " ".$_GET['order']['0']['dir'];
        }

        if (isset($_GET['length'])) {
            if ($_GET['length'] !== -1) {
                $query .= " LIMIT " . $_GET['start'] . ', ' . $_GET['length'];
            }
        }

        $rows = DB::select($query, $whereClause, PDO::FETCH_NUM);
        $recordsTotal = count(DB::select($queryTotal, $whereClause, PDO::FETCH_NUM));

        $output = [
            "draw" => intval($_GET['draw'] ?? 1),
            "recordsTotal" => count($rows),
            "recordsFiltered" => $recordsTotal,
            "data" => $rows
        ];

        return json_encode($output);
    }
}