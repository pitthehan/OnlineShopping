<?php 

    class MyCart extends Zend_Db_Table {
        protected  $_name = 'mycart';
        var $total_price = 0;
        
        //add
        function addProduct($userId, $productId, $nums=1) {
            $where = "userid=$userId AND bookid=$productId";
            $res = $this->fetchAll($where)->toArray();
            if(count($res)>0) {
                //this product has already been added to the cart, so update the nums
                $old_nums = $res[0]['nums'];
                $data = array('nums'=>$old_nums+1);
                $where = "userid=$userId AND bookid=$productId";
                $this->update($data, $where);
                return true;
            } else {
                $now = time();
                $data = array ('userid'=>$userId, 'bookid'=>$productId, 'nums'=>$nums, 'cartDate'=>$now );
                if( $this->insert($data)>0 ) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        
        //delete
        function delProduct($userid, $id) {
            if ($this->delete("userid=$userid AND bookid=$id")>0){
                return true;
            } else {
                return false;
            }
        }
        //update
        function updateProduct($userid, $id, $newNums) {
            $set = array('nums'=>$newNums);
            $where = "userid=$userid AND bookid=$id";
            $this->update($set, $where);    
        }
        
        
        
        //show mycart and compute total cost
        function showMyCart($userId) {
            $sql = "select b.id, b.name, b.price, b.publishHouse, m.nums from book b, mycart m where b.id=m.bookid AND m.userid=$userId";
            $db = $this->getAdapter();
            $res = $db->query($sql)->fetchAll();
            //compute total price
  
            for($i=0; $i<count($res); $i++) {
                $bookinfo = $res[$i];
                $this->total_price += $bookinfo['price']*$bookinfo['nums'];
            }
            
            return $res;
            
        }
    }