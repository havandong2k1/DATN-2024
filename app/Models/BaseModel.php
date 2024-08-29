<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\Utils;

class BaseModel extends Model
{
    protected $table      = '';
    protected $primaryKey = '';

    /*autoIncrement*/
    protected $useAutoIncrement = false;
    /*for delete logical*/
    protected $useSoftDeletes = true;
    /*the type of data that is returned
    */
    protected $returnType     = 'array';// or 'object'
    protected $protectFields        = true;
    //Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    /*Validating data
    */
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;
    // Callbacks
    protected $allowCallbacks       = true;
    protected $afterInsert          = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];
    protected $beforeInsert = ['beforeInsert'];//defined below
    protected $beforeUpdate = ['beforeUpdate'];//defined below

    /**
     * Instance of the encrypter object.
     *
     */
    protected $encrypter;
    /**
     * Called during initialization. Appends
     * our custom field to the module's model.
     */
//    protected function initialize()
//    {
//        $this->utils = new Utils(); // create an instance of Utils-Library class
//        $this->encrypter = \Config\Services::encrypter(); // create an instance of Encrypter class
//    }

    /* delete by id*/
    public function deleteById($id){
        $this->delete($id);
    }
    /* delete by conditions */
    public function deleteByConditions($conditions){
        $this->where($conditions);
        $this->delete();
    }
    /*delete by multi-ids*/
    public function deleteMultiIds($arrIds){
        $this->whereIn($this->primaryKey, $arrIds)->delete();
    }

    /*for save by conditions*/
    public function updateDataByConditions($conditions, $dataUpdates,
                                           $withJoinTable1='', $withJoinConditions1='', $typeJoin1='',
                                           $withJoinTable2='', $withJoinConditions2='', $typeJoin2=''){
        //Lưu ý: khi sử dụng join thì phải chỉ định select tới bảng hiện tại, vì dữ liệu các bảng join không có dữ liệu update
        $this->select($this->table . ".*");
        if($withJoinTable1!=''&&$withJoinConditions1!=''){
            if($typeJoin1=='') $typeJoin1 = 'inner';
            $this->join($withJoinTable1,$withJoinConditions1, $typeJoin1);
        }
        if($withJoinTable2!=''&&$withJoinConditions2!=''){
            if($typeJoin2=='') $typeJoin2 = 'inner';
            $this->join($withJoinTable2,$withJoinConditions2, $typeJoin2);
        }
        if(empty($conditions)==false && $conditions != ''){
            $this->where($conditions);
        }
        $countUpdated = $this->countAllResults(false);
        if($countUpdated > 0){
            $this->set($dataUpdates);
            $this->update();
        }
        return $countUpdated;
    }

    /**
     * @param $condition
     * @param $values
     * @param $dataUpdates
     * @return mixed
     * @throws \ReflectionException
     * update multi by condition
     */
    public function updateMultiCondition($condition, $values, $dataUpdates)
    {
        if (empty($condition) == false) {
            $this->whereIn($condition, $values);
        }
        $countUpdated = $this->countAllResults(false);
        if ($countUpdated > 0) {
            $this->set($dataUpdates);
            $this->update();
        }
        return $countUpdated;
    }

    /*for save by array ids*/
    public function updateDataByIds($ids, $dataUpdates, $conditions = ''){
        if(empty($ids)==false && $ids != ''){
            $this->whereIn($this->primaryKey, $ids);
        }
        if($conditions != ''){
            $this->where($conditions);
        }
        $countUpdated = $this->countAllResults(false);
        if($countUpdated>0){
            $this->set($dataUpdates);
            $this->update();
        }
        return $countUpdated;
    }

    /*get data by id*/
    public function getById($id, $withSelect='', $withJoinTable1='', $withJoinConditions1='', $typeJoin1='',
                            $withJoinTable2='', $withJoinConditions2='', $typeJoin2='', $manualWhere = '')
    {
        if($withSelect!=''){
            $this->select($withSelect);
        }
        if($withJoinTable1!=''&&$withJoinConditions1!=''){
            if($typeJoin1=='') $typeJoin1 = 'inner';
            $this->join($withJoinTable1,$withJoinConditions1, $typeJoin1);
        }
        if($withJoinTable2!=''&&$withJoinConditions2!=''){
            if($typeJoin2=='') $typeJoin2 = 'inner';
            $this->join($withJoinTable2,$withJoinConditions2, $typeJoin2);
        }
        if($manualWhere != ''){
            $this->where($manualWhere);
        }
        $this->where($this->primaryKey, $id);
        return $this->first();
    }

    /*get by multi-conditions
    * to except the deleted-logical records
    * note: in conditions: put "deleted_at"	=> null
    * @param:
    * $conditions: array of condition, ex: 'id' => '123'
    * Optional $limit is number, $orderBy is 'name of field' + $inc = 'desc' or 'asc'
    * $withSelect,  $withJoinTable + $withJoinConditions, $groupBy
    * @return array results or false
    */
    public function getByConditions($conditions, $orderBy='', $withSelect='',
                                    $withJoinTable1='', $withJoinConditions1='', $typeJoin1 = '',
                                    $withJoinTable2='', $withJoinConditions2='', $typeJoin2 = '',
                                    $groupBy='', $limit=0, $manualWhere = ''){
        if($withSelect!=''){
            $this->select($withSelect);
        }
        if($withJoinTable1!=''&&$withJoinConditions1!=''){
            if($typeJoin1==''){
                $typeJoin1 = 'inner';
            }
            $this->join($withJoinTable1, $withJoinConditions1, $typeJoin1);
        }
        if($withJoinTable2!=''&&$withJoinConditions2!=''){
            if($typeJoin2==''){
                $typeJoin2 = 'inner';
            }
            $this->join($withJoinTable2, $withJoinConditions2, $typeJoin2);
        }
        if($manualWhere != ''){
            $this->where($manualWhere);
        }
        if($conditions!=''){
            $this->where($conditions);
        }
        if($groupBy!=''){
            $this->groupBy($groupBy);
        }
        if($orderBy!=''){
            $this->orderBy($orderBy);
        }
        if($limit>0){
            $this->limit($limit);
        }
        return $this->get()->getResultArray();
    }

    /*get by multi-conditions
     * to except the deleted-logical records
     * note: in conditions: put "deleted_at"	=> null
     * @param:
     * $conditions: array of condition, ex: 'id' => '123'
     * Optional $limit is number, $orderBy is 'name of field' + $inc = 'desc' or 'asc'
     * $withSelect,  $withJoinTable + $withJoinConditions, $groupBy
     * @return the first record from array results by
     *
     */
    public function getFirstByConditions($conditions, $orderBy='', $withSelect='',
                                         $withJoinTable1='', $withJoinConditions1='', $typeJoin1='',
                                         $withJoinTable2='', $withJoinConditions2='', $typeJoin2='',
                                         $withJoinTable3='', $withJoinConditions3='', $typeJoin3='',
                                         $withJoinTable4='', $withJoinConditions4='', $typeJoin4='',
                                         $groupBy='', $limit=0, $manualWhere = ''){
        if($withSelect!=''){
            $this->select($withSelect);
        }
        if($withJoinTable1!=''&$withJoinConditions1!=''){
            if($typeJoin1=='') $typeJoin1 = 'inner';
            $this->join($withJoinTable1,$withJoinConditions1, $typeJoin1);
        }
        if($withJoinTable2!=''&&$withJoinConditions2!=''){
            if($typeJoin2=='') $typeJoin2 = 'inner';
            $this->join($withJoinTable2,$withJoinConditions2, $typeJoin2);
        }
        if($withJoinTable3!=''&&$withJoinConditions3!=''){
            if($typeJoin3=='') $typeJoin3 = 'inner';
            $this->join($withJoinTable3,$withJoinConditions3, $typeJoin3);
        }
        if($withJoinTable4!=''&&$withJoinConditions4!=''){
            if($typeJoin4=='') $typeJoin4 = 'inner';
            $this->join($withJoinTable4,$withJoinConditions4, $typeJoin4);
        }
        if($manualWhere != ''){
            $this->where($manualWhere);
        }
        $this->where($conditions);
        if($groupBy!=''){
            $this->groupBy($groupBy);
        }
        if($orderBy!=''){
            $this->orderBy($orderBy);
        }
        if($limit>0){
            $this->limit($limit);
        }
        return $this->first();
    }

    /*for save data in action: insert/ update */
    public function saveData($data, $id = 0, $setId = 0)
    {
        if ($id > 0) {
            $this->updateDataByConditions([$this->primaryKey => $id], $data);
        } else {
            $id = $setId;
            if($setId==0){
                $id = $this->utils->getTimeStampAsId();
            }
            $data[$this->primaryKey] = $id;
            $this->save($data);
        }
        return $id;
    }

    /*check $field doesn't exists on the database
    * true; exist
    * false: not exist
    * use for validate of add/edit object
    */
    public function checkExistField($field, $dataForm, $id, $id2 = 0){
        if(isset($dataForm[$field])==false){
            return false;
        }
        $valueCheck = trim($dataForm[$field]);
        $this->where($field, $valueCheck);
        if($id > 0 || $id != ''){
            //for edit
            $this->where($this->primaryKey.' !=', $id);
        }
        if($id2>0 || $id2!=''){
            //for edit
            $this->where($this->primaryKey.' !=', $id2);
        }
        $obj = $this->first();
        if($obj)
            return true;
        return false;
    }

    public function getLikeConditionsAjax($conditions, $like, $limit=0, $orderBy='', $withSelect='',
                                          $withJoinTable1='', $withJoinConditions1='', $typeJoin1 = '',
                                          $withJoinTable2='', $withJoinConditions2='', $typeJoin2 = '',
                                          $groupBy=''){
        if($withSelect!=''){
            $this->select($withSelect);
        }
        if($withJoinTable1!=''&&$withJoinConditions1!=''){
            if($typeJoin1==''){
                $typeJoin1 = 'inner';
            }
            $this->join($withJoinTable1, $withJoinConditions1, $typeJoin1);
        }
        if($withJoinTable2!=''&&$withJoinConditions2!=''){
            if($typeJoin2==''){
                $typeJoin2 = 'inner';
            }
            $this->join($withJoinTable2, $withJoinConditions2, $typeJoin2);
        }
        if($conditions!=''){
            $this->where($conditions);
        }
        if($like!=''){
            $this->like($like);
        }
        if($groupBy!=''){
            $this->groupBy($groupBy);
        }
        if($orderBy!=''){
            $this->orderBy($orderBy);
        }
        if($limit>0){
            $this->limit($limit);
        }
        return $this->get()->getResultArray();
    }

    public function countDataByConditions($conditions){
        $this->where($conditions);
        return $this->countAllResults(false);
    }

    public function runQueryDirectly($query){
        if($query != ''){
            $this->db->query($query);
        }
    }
}