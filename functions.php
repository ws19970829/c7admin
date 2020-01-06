<?php
function staticAdmin(){
    return '/admin/';
}
function treeLevel(array $data, int $pid = 0, string $html = '--', int $level = 0) {
    static $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['html'] = str_repeat($html, $level * 2);
            $val['level'] = $level + 1;
            $arr[] = $val;
            treeLevel($data, $val['id'], $html, $val['level']);
        }
    }
    return $arr;
}
function subTree(array $data, int $pid = 0){
    $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['sub'] = subTree($data,$val['id']);
            $arr[] = $val;
        }
    }
    return $arr;
}
function subTree2(array $data, int $pid = 0){
    $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['sub'] = subTree($data,$val['id']);
            $arr[$val['field_name']] = $val;
        }
    }
    return $arr;
}
function get_cate_list($list, $pid = 0, $level = 0)
{
    static $tree = array();
    foreach ($list as $row) {
        if ($row['pid'] == $pid) {
            $row['level'] = $level;
            $tree[] = $row;
            get_cate_list($list, $row['id'], $level + 1);
        }
    }

    return $tree;
}
function get_tree_list($list)
{
    //将每条数据中的id值作为其下标
    $temp = [];
    foreach ($list as $v) {
        $v['son'] = [];
        $temp[$v['id']] = $v;
    }
    //获取分类树
    foreach ($temp as $k => $v) {
        $temp[$v['pid']]['son'][] = &$temp[$v['id']];
    }

    return isset($temp[0]['son']) ? $temp[0]['son'] : [];
}