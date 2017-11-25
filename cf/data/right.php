<?php
header("Content-Type:application/json;charset=utf-8");
//pno接收客户端提交的页号
@$pno=$_REQUEST['pno'];//@表示压制错误消息显示
if(!$pno){//未提交pno
	$pno=1;
}else{//提交pno
	$pno=intval($pno);
}

//分页数的对象
$pager=[
	"recordCount"=>0,
	"pageSize"=>10,
	"pageCount"=>0,
	"pno"=>$pno,
	"data"=>[]
];

include('init.php');
  $conn=mysqli_connect($host,$aname,$apwd,$dbname,$port);
  $sql = "SET NAMES UTF8";
  mysqli_query($conn,$sql);

//$conn=mysqli_connect("localhost","root","root","cf",3306);
//$sql="SET NAMES UTF8";
//mysqli_query($conn,$sql);

//分页
$sql="select count(*)  from cf_message";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);

//总记录数
$pager["recordCount"]=intval($row["count(*)"]);
//总页数
$pager["pageCount"]=ceil($pager["recordCount"]/$pager["pageSize"]);

//从哪行开始
$start=($pager["pno"]-1)*$pager["pageSize"];
//从哪一行开始读取
$count=$pager["pageSize"];
$sql="select * from cf_message limit $start,$count";
$result=mysqli_query($conn,$sql);


while(($p=mysqli_fetch_assoc($result))!==null){
	$pager["data"][]=$p;
}
echo json_encode($pager);