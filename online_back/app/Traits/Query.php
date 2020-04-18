<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Traits;


/**
 * 查询类
 * Class Query
 * @package App\Traits
 */
trait Query {

    /**
     * dataTables的ajax搜索,以及排序
     * @param $request
     * @param $column
     * @return
     */
    public function search( $request,$column) {

        //获取关键词
        $kw = $request->get('kw','');
        //获取时间范围,没有范围就设置1970开始到现在
        $datemin = !empty($request->get('datemin'))? $request->get('datemin') : '1970-0-0';
        $datemax = !empty($request->get('datemin'))? $request->get('datemin') : date('Y-m-d');
        //拼接时间时分秒
        $datemin .= ' 00:00:00';
        $datemax .= ' 23:59:59';

        // 得到了排序的字段序号和排序的规则,datatables每一列都可以单独排序
        //因为datatables第一列序号是0,设置不参与排序
        // datatables初始化设置 以第2列为初始排序
        $order = $request->get('order')[0];
        // 以序号为数组的字段名
        $dir = $request->get('columns')[$order['column']]['data'];

        //分页,当前页和每页条数
        $start = $request->get('start');
        $limit = $request->get('length');

        //map $kw,组成模糊查询数组
        $map = [];
        if ($kw){
            $map[] = [$column,'like','%'.$kw.'%'];
        }

        //执行query语句
        //谁调用trait,$this就指代谁,trait只是代码复用的一种,算不上类
        $query = $this->with('role')->wherebetween('created_at',[$datemin,$datemax])
                    ->where($map);

        return [
            'draw' => $request->get('draw'),
            'recordsTotal' => $query->count(),//总记录数
            'recordsFiltered' => $query->count(),//过滤后记录数
            'data' => $query->orderBy($dir,$order['dir'])->offset($start)->limit($limit)->get()
        ];



        /**
         * request请求的数据
         * draw: 1
        columns[0][data]: aaa
        columns[0][name]:
        columns[0][searchable]: true
        columns[0][orderable]: false
        columns[0][search][value]:
        columns[0][search][regex]: false
        columns[1][data]: id
        columns[1][name]:
        columns[1][searchable]: true
        columns[1][orderable]: true
        columns[1][search][value]:
        columns[1][search][regex]: false
        columns[2][data]: username
        columns[2][name]:
        columns[2][searchable]: true
        columns[2][orderable]: true
        columns[2][search][value]:
        columns[2][search][regex]: false
        columns[3][data]: created_at
        columns[3][name]:
        columns[3][searchable]: true
        columns[3][orderable]: true
        columns[3][search][value]:
        columns[3][search][regex]: false
        columns[4][data]: status
        columns[4][name]:
        columns[4][searchable]: true
        columns[4][orderable]: true
        columns[4][search][value]:
        columns[4][search][regex]: false
        columns[5][data]: bbb
        columns[5][name]:
        columns[5][searchable]: true
        columns[5][orderable]: false
        columns[5][search][value]:
        columns[5][search][regex]: false
        order[0][column]: 1
        order[0][dir]: desc
        start: 0
        length: 3
        search[value]:
        search[regex]: false
        datemin:
        datemax:
        kw:
        _token: tHdyvqVB3w0rEu8Hxa6ccRjYeFBvo71foOPJ4hkH
         */







    }

}
