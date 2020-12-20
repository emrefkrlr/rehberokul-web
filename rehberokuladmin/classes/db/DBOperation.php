<?php
class DBOperation extends Model  {
    
    public function __construct() {
        parent::__construct();
        $this->bindValues = array();
    }

    // ->findAll('table name')
    // select * from table_name
    // ->findAll('table name', array('column 1', 'column 2'))
    // select column1, column2 from table_name
    // -> resultSet()
    public function findAll($tableName, $columns = null) {
        $columnSet = is_null($columns) ? '*' : implode(',', $columns);
        $this->queryString = 'SELECT '.$columnSet.' FROM '.$tableName;
    }
    // ->findByColumn('table name', 'column name', 'value')
    // select * from table_name where column_name = value
    // (if column is a date type) select * from table_name where column_name LIKE value%
    // ->findByColumn('table name', 'column name', 'value', 'NOT')
    // select * from table_name where column_name <> value
    // (if column is a date type) select * from table_name where column_name NOT LIKE value%
    // ->findByColumn('table name', 'column name', 'value', 'NOT')
    // select * from table_name where column_name <> value
    // (if column is a date type) select * from table_name where column_name NOT LIKE value%
    // ->findByColumn('table name', 'column name', 'value', null, array('column1'))
    // ->findByColumn('table name', 'column name', 'value', 'NOT', array('column1'))
    // select column1 from table_name where column_name <> value
    // (if column is a date type) select column1 from table_name where column_name NOT LIKE value%
    // -> resultSet()
    public function findByColumn($tableName, $columnName, $value, $not = null, $columns = null) {
        $columnSet = is_null($columns) ? '*' : implode(',', $columns);
        $this->queryString = 'SELECT '.$columnSet.' FROM '.$tableName.' WHERE '.$columnName;
        if(DateHelper::isDate($value)) {
            $value = $value.'%';
            is_null($not) ? '' : $this->queryString .= ' NOT';
            $this->queryString = $this->queryString.' LIKE :value';
        }else {
            $this->queryString = $this->queryString.'= :value';
            is_null($not) ? '' : $this->queryString = str_replace('=', '<>', $this->queryString);
        }
        $this->bind(':value', $value);
    }
    // ->findByColumnLike('table name', 'column name', '%value%)
    // ->findByColumnLike('table name', 'column name', 'value%)
    // ->findByColumnLike('table name', 'column name', '%value)
    // select * from table_name where column_name LIKE value
    // ->findByColumnLike('table name', 'column name', '%value%, 'NOT')
    // select * from table_name where column_name NOT LIKE value
    // ->findByColumnLike('table name', 'column name', '%value%, 'NOT', array('column1'))
    // select column1 from....
    // ->findByColumnLike('table name', 'column name', '%value%, null, array('column1))
    // -> resultSet()
    public function findByColumnLike($tableName, $columnName, $value, $not = null, $columns = null) {
        $columnSet = is_null($columns) ? '*' : implode(',', $columns);
        $this->queryString = 'SELECT '.$columnSet.' FROM '.$tableName.' WHERE '.$columnName;
        is_null($not) ? '' : $this->queryString .= ' NOT';
        $this->queryString = $this->queryString.' LIKE :value';
        $this->bind(':value', $value);
    }
    // ->findByColumnIn('table name', 'column name', ['value 1', 'value 2', 'value 3']);
    // ->findByColumnIn('table name', 'column name', array('value 1', 'value 2', 'value 3'));
    // select * from table_name where column_name IN ('value 1', 'value 2', 'value 3')
    // ->findByColumnIn('table name', 'column name', ['value 1', 'value 2', 'value 3'], 'NOT');
    // ->findByColumnIn('table name', 'column name', array('value 1', 'value 2', 'value 3'), 'NOT');
    // select * from table_name where column_name NOT IN ('value 1', 'value 2', 'value 3')
    // ->findByColumnIn('table name', 'column name', array('value 1', 'value 2', 'value 3'), 'NOT', array('column1'))
    // select column1 from table_name where column_name NOT IN ('value 1', 'value 2', 'value 3')
    // ->findByColumnIn('table name', 'column name', array('value 1', 'value 2', 'value 3'), null, array('column1'))
    // -> resultSet()
    public function findByColumnIn($tableName, $columnName, $values, $not = null, $columns = null) {
        $columnSet = is_null($columns) ? '*' : implode(',', $columns);
        $valueSet = implode(',', $values);
        $this->queryString = 'SELECT '.$columnSet.' FROM '.$tableName.' WHERE';
        is_null($not) ? '' : $this->queryString .= ' NOT';
        $this->queryString .= ' find_in_set('.$columnName;
        $this->queryString = $this->queryString.', :valueSet)';
        $this->bind(':valueSet', $valueSet);
    }
    // ->addAndClause('column name', 'value')
    // ....AND column_name = value
    // (if column is a date type) ...AND column_name LIKE value%
    // ->addAndClause('column name', 'value', 'NOT')
    // ....AND column_name <> value
    // (if column is a date type) ...AND column_name NOT LIKE value%
    // -> resultSet()
    public function addAndClause($columnName, $value, $not = null) {
        if(DateHelper::isDate($value)) {
            $value = $value.'%';
            $this->queryString = $this->queryString.' AND '.$columnName;
            is_null($not) ? '' : $this->queryString .= ' NOT';
            $this->queryString .= ' LIKE :value'.self::$BIND_COUNT;
        }else {
            $this->queryString = $this->queryString.' AND '.$columnName;
            is_null($not) ? $this->queryString.='='.':value'.self::$BIND_COUNT : $this->queryString.='<>'.':value'.self::$BIND_COUNT;
        }
        $this->bind(':value'.self::$BIND_COUNT, $value);
        self::$BIND_COUNT++;
    }
    // ->addOrClause('column name', 'value')
    // ....OR column_name=value
    // (if column is a date type) ...OR column_name LIKE value%
    // ->addOrClause('column name', 'value', 'NOT')
    // ....OR column_name <> value
    // (if column is a date type) ...OR column_name NOT LIKE value%
    // -> resultSet()
    public function addOrClause($columnName, $value, $not = null) {
        if(DateHelper::isDate($value)) {
            $value = $value.'%';
            $this->queryString = $this->queryString.' OR '.$columnName;
            is_null($not) ? '' : $this->queryString .= ' NOT';
            $this->queryString .= ' LIKE :value'.self::$BIND_COUNT;
        }else {
            $this->queryString = $this->queryString.' OR '.$columnName;
            is_null($not) ? $this->queryString.='='.':value'.self::$BIND_COUNT : $this->queryString.='<>'.':value'.self::$BIND_COUNT;
        }
        $this->bind(':value'.self::$BIND_COUNT, $value);
        self::$BIND_COUNT++;
    }
    // ->addLikeClause('column name', '%value', 'OR')
    // ->addLikeClause('column name', 'value%', 'OR')
    // ->addLikeClause('column name', '%value%', 'AND')
    // ...AND column_name LIKE value (value may be %data%, %data or data%)
    // ...OR column_name LIKE value (value may be %data%, %data or data%)
    // ->addLikeClause('column name', '%value', 'OR', 'NOT')
    // ->addLikeClause('column name', 'value%', 'OR', 'NOT')
    // ->addLikeClause('column name', '%value%', 'AND', 'NOT')
    // ...AND column_name NOT LIKE value (value may be %data%, %data or data%)
    // ...OR column_name NOT LIKE value (value may be %data%, %data or data%)
    // -> resultSet()
    public function addLikeClause($columnName, $value, $andOr, $not = null) {
        switch($andOr) {
            case 'AND':
                $this->queryString = $this->queryString.' AND '.$columnName;
                break;
            case 'OR':
                $this->queryString = $this->queryString.' OR '.$columnName;
                break;
            default:
                break;
        }
        is_null($not) ? '' : $this->queryString .= ' NOT';
        $this->queryString = $this->queryString.' LIKE :value'.self::$BIND_COUNT;
        $this->bind(':value'.self::$BIND_COUNT, $value);
        self::$BIND_COUNT++;
    }
    // ->addInClause('column name', array('value 1', 'value 2'), 'OR')
    // ->addInClause('column name', array('value 1', 'value 2'), 'AND')
    // ->addInClause('column name', ['value 1', 'value 2'], 'OR')
    // ->addInClause('column name', ['value 1', 'value 2'], 'AND')
    // ...AND column_name IN ('value 1', 'value 2')
    // ...OR column_name IN ('value 1', 'value 2')
    // ->addInClause('column name', array('value 1', 'value 2'), 'OR', 'NOT')
    // ->addInClause('column name', array('value 1', 'value 2'), 'AND', 'NOT')
    // ->addInClause('column name', ['value 1', 'value 2'], 'OR', 'NOT')
    // ->addInClause('column name', ['value 1', 'value 2'], 'AND', 'NOT')
    // ...AND column_name IN ('value 1', 'value 2', 'NOT')
    // ...OR column_name IN ('value 1', 'value 2', 'NOT')
    // -> resultSet()
    public function addInClause($columnName, $values, $andOr, $not = null) {
        $valueSet = implode(',', $values);
        switch($andOr) {
            case 'AND':
                $this->queryString = $this->queryString.' AND';
                break;
            case 'OR':
                $this->queryString = $this->queryString.' OR';
                break;
            default:
                break;
        }
        is_null($not) ? '' : $this->queryString .= ' NOT';
        $this->queryString .= ' find_in_set('.$columnName.', :valueSet'.self::$BIND_COUNT.')';
        $this->bind(':valueSet'.self::$BIND_COUNT, $valueSet);
        self::$BIND_COUNT++;
    }
    // -> limit(10);
    // ... LIMIT 10
    public function limit($limitNum) {
        $this->queryString .= ' LIMIT '.$limitNum;
    }
    // ->orderBy('id', 'DESC')
    // ... ORDER BY id DESC
    // ->orderBy('id', 'ASC')
    // ... ORDER BY id ASC
    public function orderBy($columnName, $orderType) {
        $this->queryString .= ' ORDER BY '.$columnName. ' '.$orderType;
    }
    public function orderByAddColumn($columnName, $orderType) {
        $this->queryString .= ', '.$columnName. ' '.$orderType; 
    }

    public function groupBy($columnName) {
        $this->queryString .= ' GROUP BY '.$columnName;
    }
    public function groupByAddColumn($columnName) {
        $this->queryString .= ', '.$columnName;
    }

    public function having($columnName, $columnValue, $not=null) {
        $equalOrNot = is_null($not) ? '=' : '<>';
        $this->queryString .= ' HAVING '.$columnName.' '.$equalOrNot.' :whereValue';
        $this->bind(':whereValue', $columnValue);
    }

    
    // ->save('user', array('user_id', 'title', 'body'), array('4', 'my title 4', 'my body 4'))
    // INSERT INTO user (user_id, title, body) VALUES ('4', 'my title 4', 'my body 4')
    public function save($tableName, $columns, $values) {
        $columnSet = implode(', ', $columns);
        $valueSet = implode("','", $values);
        $valueSet = "'".$valueSet."'";
        $this->queryString = 'INSERT INTO '.$tableName;
        $this->queryString .= ' ('.$columnSet.')';
        $this->queryString .= ' VALUES';
        $this->queryString .= ' ('.$valueSet.')';
       // $this->queryString .= ' (:valueSet'.self::$BIND_COUNT.')';
       // $this->bind(':valueSet'.self::$BIND_COUNT, $valueSet);
       // self::$BIND_COUNT++;
        $this->execute();
    }
    // ->deleteAll('user')
    // ->execute()
    public function deleteAll($tableName) {
        $this->queryString = 'DELETE FROM '.$tableName;
    }
    // ->deleteByColumn('user', 'body', 'my body 4')
    // DELETE FROM user WHERE body = 'my body 4'
    // ->deleteByColumn('user', 'body', 'my body 4', 'NOT')
    // DELETE FROM user WHERE body <> 'my body 4'
    // ->execute()
    public function deleteByColumn($tableName, $columnName, $value, $not = null) {
        $this->queryString = 'DELETE FROM '.$tableName.' WHERE '.$columnName;
        $this->queryString = $this->queryString.'= :value';
        is_null($not) ? '' : $this->queryString = str_replace('=', '<>', $this->queryString);
        $this->bind(':value', $value);
    }
    // ->deleteByColumnLike('table name', 'column name', '%value%)
    // ->deleteByColumnLike('table name', 'column name', 'value%)
    // ->deleteByColumnLike('table name', 'column name', '%value)
    // delete from table_name where column_name LIKE value
    // ->deleteByColumnLike('table name', 'column name', '%value%, 'NOT')
    // delete from table_name where column_name NOT LIKE value
    // -> execute()
    public function deleteByColumnLike($tableName, $columnName, $value, $not = null) {
        $this->queryString = 'DELETE FROM '.$tableName.' WHERE '.$columnName;
        is_null($not) ? '' : $this->queryString .= ' NOT';
        $this->queryString = $this->queryString.' LIKE :value';
        $this->bind(':value', $value);
    }
    // ->deleteByColumnIn('table name', 'column name', ['value 1', 'value 2', 'value 3']);
    // ->deleteByColumnIn('table name', 'column name', array('value 1', 'value 2', 'value 3'));
    // delete from table_name where column_name IN ('value 1', 'value 2', 'value 3')
    // ->deleteByColumnIn('table name', 'column name', ['value 1', 'value 2', 'value 3'], 'NOT');
    // ->deleteByColumnIn('table name', 'column name', array('value 1', 'value 2', 'value 3'), 'NOT');
    // delete from table_name where column_name NOT IN ('value 1', 'value 2', 'value 3')
    // -> resultSet()
    public function deleteByColumnIn($tableName, $columnName, $values, $not = null) {
        $valueSet = implode(',', $values);
        $this->queryString = 'DELETE FROM '.$tableName.' WHERE';
        is_null($not) ? '' : $this->queryString .= ' NOT';
        $this->queryString .= ' find_in_set('.$columnName;
        $this->queryString = $this->queryString.', :valueSet)';
        $this->bind(':valueSet', $valueSet);
    }
    /*->updateAll('user', array(
        'body' => 'HELLO'
    ));*/
    // UPDATE user SET body = 'HELLO'
    public function updateAll($tableName, $data) {
        foreach($data as $key => $value){
            $sql = $this->databaseHandler->prepare("UPDATE ".$tableName." SET ".$key." = :value");
            $sql->execute(
                array(
                    'value' => $value
                )
            );

        }
        $this->rowCount = $sql->rowCount();
    }
    // ->setWhereConditionForUpdate('id', '23', 'NOT')
    /*
    $test->updateByColumn('user', array(
            'body' => 'HELLO 1'
            ), '23');
    */
    // UPDATE user SET body = 'HELLO 1' WHERE id <> '23'
    // ->setWhereConditionForUpdate('id', '23')
    /*
    $test->updateByColumn('user', array(
            'body' => 'HELLO 1'
            ), '23');
    */
    // UPDATE user SET body = 'HELLO 1' WHERE id = '23'
    public function updateByColumn($tableName, $data, $columnValue) {
        foreach($data as $key => $value){
            $sql = $this->databaseHandler->prepare("UPDATE ".$tableName." SET ".$key." = :value ".$this->queryString);
            $sql->execute(
                array(
                    'value' => $value,
                    'columnValue' => $columnValue
                )
            );
        }
        $this->rowCount = $sql->rowCount();
    }
    // ->average('user', 'id');
    // ->single();
    public function average($tableName, $columnName) {
        $this->queryString = 'SELECT AVG('.$columnName.') AS average FROM '.$tableName;
    }

    public function sum($tableName, $columnName) {
        $this->queryString = 'SELECT SUM('.$columnName.') AS sum FROM '.$tableName;
    }
    
    // ->max('user', 'id');
    // ->single();
    public function max($tableName, $columnName) {
        $this->queryString = 'SELECT MAX('.$columnName.') AS max FROM '.$tableName;
    }
    
    // ->min('user', 'id');
    // ->single();
    public function min($tableName, $columnName) {
        $this->queryString = 'SELECT MIN('.$columnName.') AS min FROM '.$tableName;
    }
    
    // ->count('user');
    // ->where('id', '1');
    // ->single();
    // ----------------------
    // ->count('user');
    // ->single();
    // ----------------------
    // ->count('user');
    // ->where('id', '1', 'NOT');
    // ->single();
    public function count($tableName) {
        $this->queryString = 'SELECT COUNT(*) AS total FROM '.$tableName;
    }
    
    public function where($columnName, $columnValue, $not=null) {
        $equalOrNot = is_null($not) ? '=' : '<>';
        $this->queryString .= ' WHERE '.$columnName.' '.$equalOrNot.' :whereValue';
        $this->bind(':whereValue', $columnValue);
    }
    // ->setWhereConditionForUpdate('body', 'HELLO 1')
    // ->setWhereConditionForUpdate('body', 'HELLO 1', 'NOT')
    // you must use adding in clause or not clause or like clause after setWhereConditionForUpdate for compleks queries for update
    public function setWhereConditionForUpdate($columnName, $columnValue, $not = null) {
        $equalOrNot = is_null($not) ? '=' : '<>';
        $this->queryString = ' WHERE '.$columnName.' '.$equalOrNot.' :columnValue';
    }
    
    public function isUpdated() {
        return $this->getRowCount() ? true : false;
    }
    
    public function isDeleted() {
        return $this->getRowCount() ? true : false;
    }
    
    public function isInserted() {
        return $this->lastInsertId() ? true : false;
    }
    
    public function __destruct() {
        $this->databaseHandler = null;
    }
    
    
    //iç içe select atabiliyoruz in sorgularında örneği aşağıda
    //aynısı delete için de yapılabilir
    //SELECT body FROM user WHERE id IN (SELECT id FROM user WHERE body LIKE '%my body%') 
    //$test->findByColumnLike('user', 'body', '%my body%', null, array('id'));
    //$deneme = $test->resultSet();
    /*$ids = array();
    foreach($deneme as $i=>$id) {
        array_push($ids, $title['id']);
    }
    $test1 = new Test;
    $test1->findByColumnIn('user', 'id', $ids, null, array('body'));
    $deneme2 = $test1->resultSet();
    print_r($deneme2);*/

}