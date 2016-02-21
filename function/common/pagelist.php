<?php
if( !defined('IN_SKYOJSYSTEM') )
{
    exit('Access denied');
}
//Get Max Page id
//Get Min Page id (1)
//show range +-3
class PageList{
    private $table;
    private $allrow;
    const ROW_PER_PAGE = 20;
    const PAGE_RANGE   = 3; //> it will show +-PAGE_RANGE, if now at 5, it shiw 234 5 678
    private function update()
    {
        $res = DB::fetch("SELECT COUNT(*) FROM `{$this->table}`");
        if( $res===false ){
            throw new Exception("SQL Error");
        }
        $this->allrow=(int)$res[0];
    }
    
    function all():int
    {
        if( $this->allrow==0 )return 1;
        return ceil($this->allrow/PageList::ROW_PER_PAGE);
    }
    function __construct(string $t)
    {
        $this->table = DB::tname($t);
        $this->update();
    }
    
    function min(int $d):int
    {
        return max(1,$d-PageList::PAGE_RANGE);
    }
    
    function max(int $d):int
    {
        return min($this->all(),$d+PageList::PAGE_RANGE);
    }
    
    function left(int $d)
    {
        return max($d-1,$this->min($d));
    }
    
    function right(int $d)
    {
        return min($d+1,$this->max($d));
    }
};