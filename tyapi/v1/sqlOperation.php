<?php

function sqlGetRow($tableName,$field,$condition = null)
{

    $sql ="select ".$field." from ".$GLOBALS['ecs']->table($tableName);
    if(!empty($condition))
        $sql .= "where $condition";

    return $GLOBALS['db']->getRow($sql);
}

function sqlGetAll($tableName,$field,$condition = null)
{

    $sql ="select ".$field." from ".$GLOBALS['ecs']->table($tableName);
    if(!empty($condition))
        $sql .= "where $condition";

    return $GLOBALS['db']->getAll($sql);
}

function sqlGetOne($tableName,$field,$condition = null,$orderBy = null,$orderStyle=null)
{

    $sql ="select ".$field." from ".$GLOBALS['ecs']->table($tableName);
    if(!empty($condition))
        $sql .= "where $condition";

    if(!empty($orderBy))
        $sql .= " order by `$orderBy` $orderStyle";
    return $GLOBALS['db']->getOne($sql);
}

function sqlAdd($tableName,$fields = [],$values = [])
{
    $sql = "insert into ".$GLOBALS['ecs']->table($tableName);

    if(!empty($fields))
    {
        $sqlField = " ( ";
        foreach ($fields as $field)
        {
            $sqlField .= "`$field`, ";
        }
        $sqlField = substr($sqlField,0,strlen($sqlField)-2);
        $sqlField .= ") ";
        $sql .= $sqlField;
    }

    $sqlValue = " ( ";
    foreach ($values as $value)
    {
        $sqlValue .= "'$value', ";
    }
    $sqlValue = substr($sqlValue,0,strlen($sqlValue)-2);
        $sqlValue .= ") ";

    $sql .= "values ".$sqlValue;

    return $GLOBALS['db']->query($sql);
}

function sqlDelete($tableName,$condition)
{
    $sql = "delete from ";
    $sql .= $GLOBALS['ecs']->table($tableName);
    $sql .= " where $condition";

    $execResult = $GLOBALS['db']->query($sql);

    return $execResult;

}

function sqlUpdate($tableName,$setters=[],$condition)
{
    $sql = 'update '.$GLOBALS['ecs']->table($tableName).'set ';
    $setterValue = '';
    foreach ($setters as $setter)
    {
        $setterValue .= "$setter, ";
    }
    $setterValue = substr($setterValue,0,strlen($setterValue)-2);

    $sql .= $setterValue;

    $sql .= " where $condition";

    $execResult = $GLOBALS['db']->query($sql);

    return $execResult;
}