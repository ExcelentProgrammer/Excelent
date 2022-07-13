<?php

namespace Excelent\Database;

use Excelent\Error\Error;

use Exception;
use PDO;

class MainModel
{
    public $settings = [
        "type"   =>  "",
        "select" =>  [],
        "insert" =>  [],
        "update" =>  [],
        "delete" =>  [],
        "where"  =>  [],
        "create" =>  [],
        "drop"   =>  [],
        "order"  =>  [],
        "limit"  =>  [],
        "table"  =>  "",
    ];
    public $sql;
    function __construct()
    {
        try {
            $this->con = new PDO($_ENV['DB_TYPE'] . ":host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . "", $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
            $this->conInfo = true;
        } catch (Exception $e) {
            try {
                throw new Exception("Malumotlar bazasiga ulanishda xato yuz berdi");
            } catch (Exception $e) {
                $this->conInfo = false;
                Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
            }
        }
    }
    static public function my()
    {
        $self = new self();
        $vars = (object)get_class_vars(get_called_class());
        $table = isset($vars->table) ? $vars->table : end(explode("\\", get_called_class()));
        $self->settings['table'] = $table;
        return $self;
    }
    public static function select($data = ["*"])
    {
        $self = self::my();
        $self->settings['type'] = "SELECT";
        $self->settings['select'] = $data;

        return $self;
    }
    public function destroy()
    {
        $this->settings = [
            "type"   =>  "",
            "select" =>  [],
            "insert" =>  [],
            "update" =>  [],
            "delete" =>  [],
            "where"  =>  [],
            "create" =>  [],
            "drop"   =>  [],
            "order"  =>  [],
            "limit"  =>  [],
            "table"  =>  "",
        ];
    }
    public static function create(string $data)
    {
        $self = self::my();
        $self->settings['type'] = "CREATE";
        $self->settings['create'] = $data;
        return $self;
    }
    static public function con()
    {
        $self = new self();
        return $self->con;
    }
    static public function query($sql)
    {
        try {
            $res = (new self())->con->prepare($sql);
            $res->execute();
            return (object)['result' => "true", "sql" => $sql, "response" => $res];
        } catch (Exception $e) {
            Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
            return json_decode(json_encode(['result' => "false", "sql" => $sql, "error" => ["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]]), false);
        }
    }
    public static function insert(array $data)
    {
        $self = self::my();
        $self->settings['insert'] = $data;
        $self->settings['type'] = "INSERT";

        return $self;
    }
    public static function delete()
    {
        $self = self::my();
        $self->settings['type'] = "DELETE";
        $self->settings['delete'] = "";
        return $self;
    }
    public static function drop()
    {
        $self = self::my();
        $self->settings['type'] = "DROP";
        $self->settings['drop'] = "";
        return $self;
    }
    public static function update($data)
    {
        $self = self::my();
        $self->settings['type'] = "UPDATE";
        $self->settings['update'] = $data;
        return $self;
    }
    public function orderByDesc($column)
    {
        $this->settings['order'] = "ORDER BY $column DESC";
        return $this;
    }
    public function orderBy($column)
    {
        $this->settings['order'] = "ORDER BY $column";
        return $this;
    }
    public function limit($from, $to)
    {
        $this->settings['limit']['from'] = $to;
        $this->settings['limit']['to'] = $from;
        return $this;
    }
    public function where($data)
    {
        $this->settings['where'] = $data;
        return $this;
    }

    static public function table(string $table)
    {
        $self = new self();
        $self->settings['table'] = $table;
        return $self;
    }
    public function run()
    {
        if ($this->conInfo) {
            $type = $this->settings['type'];
            $select = $this->settings['select'];
            $table = $this->settings['table'];
            $where = $this->settings['where'];
            $insert = $this->settings['insert'];
            $update = $this->settings['update'];
            $create = $this->settings['create'];
            $order = !empty($this->settings['order']) ? $this->settings['order'] : "";
            $limitFrom = isset($this->settings['limit']['from']) ? $this->settings['limit']['from'] : "";
            $limitTo = isset($this->settings['limit']['to']) ? $this->settings['limit']['to'] : "";
            if (isset($this->settings['limit']['from']) and isset($this->settings['limit']['to'])) {
                $limit = " LIMIT $limitFrom OFFSET $limitTo ";
            } else {
                $limit = "";
            }


            $select = is_array($select) ? implode(", ", $select) : $select;


            if (!empty($where) and is_array($where)) {
                $wherequery = " WHERE ";
                $whereExec = $where;
                foreach ($where as $key => $value) {
                    $wherequery .= "$key = :$key";
                    if (end($where) !== $value) {
                        $wherequery .= " AND ";
                    }
                }
                $where = $wherequery;
            } elseif (!empty($where)) {
                $where = " WHERE " . $where;
            } else {
                $where = "";
            }


            if (!empty($insert)) {
                $insertKey = implode(",", array_keys($insert));
                $insertValue = implode(",:", array_keys($insert));
            }


            if (!empty($update)) {
                $updatequery = "";
                foreach ($update as $key => $value) {
                    $updatequery .= "$key = :$key";
                    if (end($update) !== $value) {
                        $updatequery .= " , ";
                    }
                }
            } else {
                $updatequery = "";
            }





            switch ($type) {
                case 'SELECT':
                    $query = "SELECT $select FROM $table $where $order $limit";
                    try {
                        $res = $this->con->prepare($query);
                        $res->execute($whereExec);
                        $RowCount = $res->rowCount();
                        $Data = $res->fetchAll();
                        $this->destroy();
                        return (object)["RowCount" => $RowCount, "Data" => $Data, 'result' => "true", 'sql' => $res->queryString];
                    } catch (Exception $e) {
                        Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
                        return json_decode(json_encode(['result' => "false", "sql" => $query, "error" => ["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]]), false);
                    }
                    break;
                case 'INSERT':

                    $query = "INSERT INTO $table ($insertKey) VALUES (:$insertValue)";
                    try {
                        $con = $this->con;
                        $res = $con->prepare($query);
                        $res->execute($insert);
                        try {
                            $insertId = $con->lastInsertId();
                            $this->destroy();
                            return (object)["InsertId" => $con->lastInsertId(), "result" => "true", "sql" => $res->queryString];
                        } catch (Exception $e) {
                            $this->destroy();
                            return (object)["InsertId" => 'null', "result" => "true", 'sql' => $res->queryString];
                        }
                    } catch (Exception $e) {

                        Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);

                        return json_decode(json_encode(['result' => "false", "sql" => $query, "error" => ["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]]), false);
                    }

                    break;
                case 'UPDATE':
                    $query = "UPDATE $table SET $updatequery $where";
                    try {
                        $res = $this->con->prepare($query);
                        print_r($where);
                        $this->destroy();
                        $res->execute(!empty($whereExec) ? $update + $whereExec : $update);
                        return (object)['result' => "true", 'sql' => $res->queryString];
                    } catch (Exception $e) {
                        Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
                        return json_decode(json_encode(['result' => "false", "sql" => $query, "error" => ["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]]), false);
                    }
                    break;
                case 'DELETE':
                    $query = "DELETE FROM $table $where";
                    try {
                        $res = $this->con->prepare($query);
                        $this->destroy();
                        $res->execute($whereExec);
                        return (object)['result' => "true", 'sql' => $res->queryString];
                    } catch (Exception $e) {
                        Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
                        return json_decode(json_encode(['result' => "false", "sql" => $query, "error" => ["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]]), false);
                    }
                    break;
                case 'DROP':
                    $query = "DROP TABLE $table";
                    try {
                        $res = $this->con->prepare($query);
                        $res->execute();
                        $this->destroy();
                        return (object)['result' => "true", 'sql' => $res->queryString];
                    } catch (Exception $e) {
                        Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
                        return json_decode(json_encode(['result' => "false", "sql" => $query, "error" => ["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]]), false);
                    }
                    break;
                case 'CREATE':
                    $query = "CREATE TABLE $table($create)";
                    try {
                        $res = $this->con->prepare($query);
                        $res->execute();
                        $this->destroy();
                        return (object)['result' => "true", 'sql' => $res->queryString];
                    } catch (Exception $e) {
                        Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
                        return json_decode(json_encode(['result' => "false", "sql" => $query, "error" => ["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]]), false);
                    }
                    break;

                default:
                    try {
                        throw new Exception("SELECT||UPDATE||DROP||DELETE||INSERT||CREATE|| BIRORTASI TANLASHINGGIZ KERAK");
                    } catch (Exception $e) {
                        Error::error(["message" => $e->getMessage(), "line" => $e->getLine(), "trace" => $e->getTrace()]);
                    }
                    break;
            }
        }
    }
}
