<?php
/**
 * DB 유틸리티 클래스
 * @file    Db.class.php
 * @author  Yongmin Ma (milgam12@inplusweb.com)
 * @package util
 */

class Db
{
    /**
     * Db 커넥션 생성 후 리턴
     * @return \mysqli
     */
    private function getConnection()
    {
        if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD)) {
            Html::printError('DB Connection Error');
            exit;
        }

        if (!mysqli_select_db($link, DB_NAME)) {
            Html::printError('DB Selection Error');
            exit;
        }

        return $link;
    }

    /**
     * 쿼리 실행
     * @param string $query
     * @param bool $flag_log_query
     * @return \mysqli_result
     */
    private function executeQuery($query, $flag_log_query = false)
    {
        $result = mysqli_query(self::getConnection(), $query);

        // DB 결과 로그
        if (LOG_QUERY || $flag_log_query) {
            Log::query($query, $result);
        }

        return $result;
    }

    /**
     * Select 쿼리 실행
     * @param string $table
     * @param string $column
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param bool $flag_log_query
     * @return array
     */
    public static function select($table, $column, $where, $order, $limit, $flag_log_query = false)
    {
        $query = 'SELECT ' . $column . ' FROM ' . $table . ' ' . $where . ' ' . $order . ' ' . $limit . ';';

        $result = self::executeQuery($query, $flag_log_query);
        $list = null;
        while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $list[] = $data;
        }

        return $list;
    }

    /**
     * Select limit 1 쿼리 실행
     * @param string $table
     * @param string $column
     * @param string $where
     * @param string $order
     * @param bool $flag_log_query
     * @return array
     */
    public static function selectOnce($table, $column, $where, $order, $flag_log_query = false)
    {
        $query = 'SELECT ' . $column . ' FROM ' . $table . ' ' . $where . ' ' . $order . ' limit 1;';

        $result = self::executeQuery($query, $flag_log_query);
        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $data;
    }

    /**
     * Select count() 쿼리 실행
     * @param string $table
     * @param string $where
     * @param bool $flag_log_query
     * @return int
     */
    public static function selectCount($table, $where, $flag_log_query = false)
    {
        $query = 'SELECT COUNT(*) AS cnt '. 'FROM ' . $table . ' ' . $where . ';';

        $result = self::executeQuery($query, $flag_log_query);
        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return $data['cnt'];
    }

    /**
     * Insert 쿼리 실행
     * @param string $table
     * @param string $column
     * @param string $value
     * @param bool $flag_log_query
     * @return \mysqli_result
     */
    public static function insert($table, $column, $value, $flag_log_query = false)
    {
        $query = 'INSERT ' . 'INTO ' . $table . ' (' . $column . ') VALUES(' .$value . ');';
        $result = self::executeQuery($query, $flag_log_query);

        return $result;
    }

    /**
     * 배열을 이용한 Insert 쿼리 실행
     * @param string $table
     * @param array $arr
     * @param bool $flag_log_query
     * @return \mysqli_result
     */
    public static function insertByArray($table, $arr, $flag_log_query = false)
    {
        $column = '';
        $value = '';

        $seq = 0;
        foreach ($arr as $key => $val) {
            if ($seq > 0) {
                $column .= ',';
                $value .= ',';
            }
            $column .= $key;
            $value .= "'$val'";
            $seq++;
        }

        return self::insert($table, $column, $value, $flag_log_query);
    }

    /**
     * Update 쿼리 실행
     * @param string $table
     * @param string $column_value
     * @param string $where
     * @param bool $flag_log_query
     * @return \mysqli_result
     */
    public static function update($table, $column_value, $where, $flag_log_query = false)
    {
        $query = 'UPDATE ' . $table . ' SET ' . $column_value . ' ' . $where . ';';
        $result = self::executeQuery($query, $flag_log_query);

        return $result;
    }

    /**
     * 배열을 이용한 Update 쿼리 실행
     * @param string $table
     * @param string $arr
     * @param string $where
     * @param bool $flag_log_query
     * @return \mysqli_result
     */
    public static function updateByArray($table, $arr, $where, $flag_log_query = false)
    {
        $column_value = '';

        $seq = 0;
        if (!is_array($arr)) {
            return null;
        }
        foreach ($arr as $key => $val) {
            if (!$key) {
                continue;
            }
            if ($seq > 0) {
                $column_value .= ', ';
            }
            $column_value .= "$key = '$val'";
            $seq++;
        }
        return self::update($table, $column_value, $where, $flag_log_query);
    }

    /**
     * Delete 쿼리 실행
     * @param string $table
     * @param string $where
     * @param bool $flag_log_query
     * @return \mysqli_result
     */
    public static function delete($table, $where, $flag_log_query = false)
    {
        $query = 'DELETE ' . 'FROM ' . $table . ' ' . $where . ';';
        $result = self::executeQuery($query, $flag_log_query);

        return $result;
    }
}


?>