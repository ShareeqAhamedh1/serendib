<?php
  include 'conn.php';

  $redirect_link = $_SESSION['last_logged_url'];
  $id = $_REQUEST['id'];
  $cod_amount = mysqli_real_escape_string($conn,$_REQUEST['cod_amount']);
  $add = mysqli_real_escape_string($conn,$_REQUEST['add']);
  $confirmed_date_value = mysqli_real_escape_string($conn,$_REQUEST['confirmed_date_value']);
  $dis = mysqli_real_escape_string($conn,$_REQUEST['dis']);
  $city = mysqli_real_escape_string($conn,$_REQUEST['city']);
  $subitem = mysqli_real_escape_string($conn,$_REQUEST['sub_item']);

  $pay_st = mysqli_real_escape_string($conn,$_REQUEST['pay_type']);

  $remark = mysqli_real_escape_string($conn,$_REQUEST['remark']);

  $dis = getDataBack($conn,'districts','id',$dis,'name_en');

  $item = mysqli_real_escape_string($conn,$_REQUEST['desc']);
  $del_method = mysqli_real_escape_string($conn,$_REQUEST['del_method']);

  $or_up_date = date('Y-m-d');
  $or_update_time = date('H:i:s');

  $adminId = $_SESSION['uid'];

  if($confirmed_date_value != ""){
    $or_up_date = $confirmed_date_value;
  }

  $marked_date=date('Y-m-d');

  if($dis == "" && $city == ""){
    if($item == ""){
        $sql = "UPDATE tbl_orders SET address='$add',
        cod_amount='$cod_amount',
        adm_uid='$adminId',
        or_st_date='$or_up_date',
        or_up_time='$or_update_time',
        del_method='$del_method',
        remarks='$remark',or_status='1',pay_st='$pay_st',confirmed_date='$marked_date' WHERE or_id ='$id'";
    }
    else{
        $sql = "UPDATE tbl_orders SET address='$add',
        or_desc='$item',
        cod_amount='$cod_amount',
        adm_uid='$adminId',
        or_st_date='$or_up_date',
        or_up_time='$or_update_time',
        del_method='$del_method',
        remarks='$remark',or_status='1',pay_st='$pay_st',confirmed_date='$marked_date' WHERE or_id ='$id'";
    }

  }
  else {
    if($item == ""){
        $sql = "UPDATE tbl_orders SET address='$add',
                                  cod_amount='$cod_amount',
                                  adm_uid='$adminId',
                                  distric='$dis',
                                  city='$city',
                                  or_st_date='$or_up_date',
                                  or_up_time='$or_update_time',
                                  del_method='$del_method',
                                  remarks='$remark',or_status='1',pay_st='$pay_st',confirmed_date='$marked_date' WHERE or_id ='$id'";
    }
    else{
        $sql = "UPDATE tbl_orders SET address='$add',
                                  or_desc='$item',
                                  cod_amount='$cod_amount',
                                  adm_uid='$adminId',
                                  distric='$dis',
                                  city='$city',
                                  or_st_date='$or_up_date',
                                  or_up_time='$or_update_time',
                                  del_method='$del_method',
                                  sub_name='$subitem',
                                  remarks='$remark',or_status='1',pay_st='$pay_st',confirmed_date='$marked_date' WHERE or_id ='$id'";

    }

  }

  $rs = $conn->query($sql);


  if ($rs > 0){
    header('location:'.$redirect_link);
    $_SESSION['confed'] = true;
  }
  else {
    header('location:'.$redirect_link);
    $_SESSION['confedErr'] = true;
  }
 ?>
