<?php
require $BasePath . '/Helpers/MYSQL/MysqlConfig.php';

class MYSQLInstance
{
    public $Connection;
    public $schema;

    public function __construct(Schema $schema)
    {
        if (gettype($schema) != 'object')
            throw new Exception('Invalid schema object.');

        $this->schema = $schema;

        $this->Connection = mysql_connect(DB_HOST, DB_USER, DB_PASS);

        $this->ensureConnected();
        $schema->CreateSchema($this->Connection);
    }

    private function ensureConnected()
    {
        if (!$this->Connection)
            throw new Exception('Database is not connected.');
    }

    public function InsertRows($table, array $contents)
    {
        $this->ensureConnected();

        $columns = '';
        $values = '';

        foreach ($contents as $k => $v)
        {
            if ($columns !== '')
                $columns .= ',';
            $columns .= $this->escapeString($k);
            if ($values !== '')
                $values .= ',';
            $values .= "'" . $this->escapeString($v) . "'";
        }

        $sql = sprintf('INSERT INTO %s%s (%s) VALUES (%s);'
            , $this->schema->DB_PREFIX
            , $this->escapeString($table)
            , $columns
            , $values);

        return mysql_query($sql, $this->Connection);
    }

    public function SelectRows($table, array $search)
    {
        $this->ensureConnected();

        $multiSearchString = $this->constructMultiQuery($search);

        $sql = sprintf('SELECT * FROM %s%s WHERE %s;'
            , $this->schema->DB_PREFIX
            , $this->escapeString($table)
            , $multiSearchString);

        return mysql_query($sql, $this->Connection);
    }

    public function UpdateRows($table, array $contents, array $search = null)
    {
        $this->ensureConnected();

        $multiSearchString = $this->constructMultiQuery($search);
        $multiContentsString = $this->constructMultiQuery($contents, ',');

        $sqlString = 'UPDATE %s SET %s';
        if ($search != null)
            $sqlString .= ' WHERE %s';
        $sql = sprintf($sqlString, $table, $multiContentsString, $multiSearchString);

    }

    public function SelectRowsLimit($table, array $search, $start, $count = 0)
    {
        $this->ensureConnected();

        $multiSearchString = $this->constructMultiQuery($search);

        $sql = sprintf('SELECT * FROM %s%s WHERE %s LIMIT %s;'
            , $this->schema->DB_PREFIX
            , $this->escapeString($table)
            , $multiSearchString
            , $start . ($count === 0 ? '' : ",$count"));

        return mysql_query($sql, $this->Connection);
    }

    public function DeleteRows($table, array $search)
    {
        $this->ensureConnected();

        $multiSearchString = $this->constructMultiQuery($search);

        $sql = sprintf('DELETE FROM %s%s WHERE %s;'
            , $this->schema->DB_PREFIX
            , $this->escapeString($table)
            , $multiSearchString);

        return mysql_query($sql, $this->Connection);
    }

    public function TableExists($table)
    {
        $sql = sprintf('SHOW TABLES LIKE %s%s;'
            , $this->schema->DB_PREFIX
            , $this->escapeString($table));

        $result = mysql_query($sql, $this->Connection);

        if ($result == false || mysql_num_rows($result) == 0)
            return false;
        return true;
    }

    private function escapeString($data)
    {
        return mysql_real_escape_string($data);
    }

    private function constructMultiQuery(array $data, $splitter = '=')
    {
        $ret = '';
        foreach ($data as $k => $v)
        {
            if ($ret !== '')
                $ret .= ' AND ';
            $ret .= $this->escapeString($k) . '=' . "'" . $this->escapeString($v) . "'";
        }
        return $ret;
    }

}

?>