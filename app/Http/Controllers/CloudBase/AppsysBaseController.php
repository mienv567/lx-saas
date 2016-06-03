<?php

namespace App\Http\Controllers\CloudBase;

use DB;
use Redirect;
use App\Http\Controllers\Controller;

/**
 * 云应用系统基础操作控制器类
 */
class AppsysBaseController extends Controller
{
    
    /**
     * Blade模版前缀
     */
    protected $bladePrefix = '';
    
    /**
     * 限制只操作部署在指定位置的应用产品，如果此值小于或等于0，那么表示不限部署位置
     */
    protected $limitDeployPosition = 0;
    
    /**
     * 购买的产品类型：0-云服务；1-云系统；2-云平台
     */
    protected $productType = 0;
    
    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 判断产品是否存在或是否可见（已上架、符合当前部署位置） 
     * @param $product 产品信息
     * @return 产品是否存在或是否有效
     */
    protected function isVisibleProduct($product)
    {
        // 判断产品是否存在、已上架、可购买
        if (empty($product) || $product->sale_visible == 0) {
            return false;
        }
        // 判断产品是否符合当前部署位置
        if ($this->limitDeployPosition > 0 && $product->deploy_position != 0 && $product->deploy_position != $this->limitDeployPosition) {
            return false;
        }
        // 返回结果
        return true;
    }

    /**
     * 判断产品是否存在或是否有效（已上架、可购买、符合当前部署位置）
     * @param $product 产品信息
     * @return 产品是否存在或是否有效
     */
    protected function isValidProduct($product)
    {
        // 判断产品是否存在、已上架、可购买
        if (empty($product) || $product->sale_visible == 0 || $product->sale_enabled == 0) {
            return false;
        }
        // 判断产品是否符合当前部署位置
        if ($this->limitDeployPosition > 0 && $product->deploy_position != 0 && $product->deploy_position != $this->limitDeployPosition) {
            return false;
        }
        // 返回结果
        return true;
    }
    
    /**
     * 获取URI前缀
     * @return URI前缀
     */
    protected  function getUriPrefix()
    {
        if ($this->productType == 1) {
            return 'cloud_system';
        } else if ($this->productType == 2) {
            return 'cloud_platform';
        } else {
            return '';
        }
    }
    
    /**
     * 提供到一对多关联表的子表查询关联的子记录信息，并赋值给指定主记录列表中的各条记录。 
     * @param $records 主记录列表
     * @param $subTableName 子表表名
     * @param $relColumnName 子表中关联到主表的字段名
     * @param $addToFieldName 子记录信息保存到主记录的元素名
     * @param $orderColumnName 子表排序字段名
     * @param $orderType 子表排序类型
     * @param $softDeleteable 目标子表是否支持软删除
     */
    protected function addSubTableInfo($records, $subTableName, $relColumnName, $addToFieldName, $orderColumnName = NULL, $orderType = NULL, $softDeleteable = false)
    {
        // 获取记录列表中的ID数组
        $ids = array();
        foreach ($records as $record) {
            $ids[] = $record->id;
        }
        // 根据记录ID数组到关联子表中查询关联的子元素信息列表
        $subInfoMap = array();
        if (!empty($ids)) {
            $query = DB::table($subTableName)->whereIn($relColumnName, $ids);
            if ($softDeleteable) {
                $query->whereNull('deleted_at');
            }
            $query->orderBy($relColumnName);
            if (!empty($orderColumnName)) {
                if (empty($orderType)) {
                    $orderType = 'asc';
                }
                $query->orderBy($orderColumnName, $orderType);
            }
            $rows = $query->get();
            $prevId = -1;
            $subInfos = array();
            foreach ($rows as $row) {
                $relId = $row->$relColumnName;
                if ($relId != $prevId) {
                    if (!empty($subInfos)) {
                        $subInfoMap[''.$prevId] = $subInfos;
                    }
                    $subInfos = array();
                    $prevId = $relId;
                }
                $subInfos[] = $row;
            }
            if (!empty($subInfos)) {
                $subInfoMap[''.$prevId] = $subInfos;
            }
        }
        // 将查询到的子元素信息赋值到相应记录的指定字段中
        foreach ($records as $record) {
            $key = ''.$record->id;
            if (array_key_exists($key, $subInfoMap)) {
                $record->$addToFieldName = $subInfoMap[$key];
            }
        }
        // 返回新记录信息
        return $records;
    }
    
}
