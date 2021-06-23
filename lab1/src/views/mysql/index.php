<?php

class QueryBuilder
{
    /** @var PDO */
    private $connection;
    private $select;
    private $from;
    private $join;
    private $where;

    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->select = [];
        $this->from = '';
        $this->join = [];
        $this->where = [];
    }

    public function select($column)
    {
        $this->select[] = $column;

        return $this;
    }

    public function from($from) {
        $this->from = $from;

        return $this;
    }

    public function join($table, $first, $operator, $second)
    {
        $this->join[] = [
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second,
        ];

        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->where[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
        ];

        return $this;
    }

    public function when($condition, $closure)
    {
        if ($condition) {
            $closure($this);
        }

        return $this;
    }

    private function getWhereStatements()
    {
        $whereStatements = [];

        foreach ($this->where as $index => $condition) {
            $whereStatements[] = [
                'stmt' => $condition['column'] . ' ' . $condition['operator'] . ' ' . ':whereValue' . $index,
                'bind' => [
                    'whereValue' . $index => $condition['value'],
                ]
            ];
        }

        return $whereStatements;
    }

    private function getJoinStatements()
    {
        $joinStatements = [];

        foreach ($this->join as $index => $condition) {
            $joinStatements[] = [
                'stmt' => ' INNER JOIN ' .  $condition['table'] .
                    ' ON ' .$condition['first'] . ' ' . $condition['operator'] . ' ' . $condition['second'],
            ];
        }

        return $joinStatements;
    }

    public function get()
    {
        $sqlString = 'SELECT ' . implode(', ', $this->select) . ' FROM ' . $this->from;
        $bindings = [];

        $joinStmt = $this->getJoinStatements();

        if (!empty($joinStmt)) {
            foreach ($joinStmt as $join) {
                $sqlString .= $join['stmt'];
            }
        }

        $whereStmt = $this->getWhereStatements();

        if (!empty($whereStmt)) {
            $sqlString .= ' WHERE ';

            $sqlString .= implode(' AND ', array_column($whereStmt, 'stmt'));
            $bindings = array_merge($bindings, ...array_column($whereStmt, 'bind'));
        }

        $stmt = $this->connection->prepare($sqlString);

        foreach ($bindings as $key => $binding) {
            $stmt->bindParam(':' . $key, $binding);
        }

        return $stmt;
    }
}


try {
    $connection = new PDO('mysql:host=localhost;port=3306;dbname=default', 'newuser', 'password');
    $builder = new QueryBuilder($connection);

    $query = $builder
        ->select('items.name')
        ->select('vendor.name as vendor_name')
        ->select('items.price')
        ->select('items.quantity')
        ->select('category.name as category_name')
        ->from('items')
        ->join('category', 'items.category_id', '=', 'category.id')
        ->join('vendor', 'items.vandor_id', '=', 'vendor.id')
        ->when(!empty($_GET['category']), function (QueryBuilder $query) {
            $query->where('category.name', '=', $_GET['category']);
        })
        ->when(!empty($_GET['distributor']), function (QueryBuilder $query) {
            $query->where('vendor.name', '=', $_GET['distributor']);
        })
        ->when(!empty($_GET['price_min']), function (QueryBuilder $query) {
            $query->where('items.price', '>=', $_GET['price_min']);
        })
        ->when(!empty($_GET['price_max']), function (QueryBuilder $query) {
            $query->where('items.price', '<=', $_GET['price_max']);
        })
        ->get();
    if (!$query->execute()) {
        var_dump($query->errorInfo());exit;
    }
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $exception) {
    var_dump($exception->getMessage());exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<br>
<br>
<br>
<br><br>
<br>

<form>
    <input type="text" name="distributor" placeholder="Enter distributor" />
    <button type="submit">Get by distributor</button>
</form>
<form>
    <input type="text" id="price-min" name="price_min" placeholder="MinPrice" value="0">
    <input type="text" id="price-max" name="price_max" placeholder="MaxPrice" value="500">
    <button type="submit">Get in that price range</button>
</form>
<form>
    <input type="text" id="category" name="category" placeholder="Enter category">
    <button type="submit">Get by category</button>
</form>
<table data-type="products-container" border="1">
    <tr>
        <th>Name</th>
        <th>Distributor</th>
        <th>price</th>
        <th>quantity</th>
        <th>category</th>
    </tr>
    <?php foreach ($result as $row):  ?>
    <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['vendor_name'] ?></td>
        <td><?= $row['price'] ?></td>
        <td><?= $row['quantity'] ?></td>
        <td><?= $row['category_name'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
