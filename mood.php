<?php
include_once("sql.php");

//心情说明，用半角逗号隔开
$moodname = '给力,淡定,学习,坑爹,打酱油';
//心情图标文件，用半角逗号隔开(images/目录)
$moodpic = 'geili.gif,dandian.gif,xuexi.gif,kengdie.gif,dajiangyou.gif';
//统计心情柱图标最大高度
$moodpicheight = 80;

$action = isset($_GET['action']) ? $_GET['action'] : "";
if ($action == 'send')
{ //发表心情
	//文章id
	$id = (int)$_POST['id'];
	//对应表情的id
	$mid = (int)$_POST['moodid'];
	if ($mid < 0 || !$id)
	{
		echo "错误";
		exit;
	}

	$havemood = chk_mood($id);
	if ($havemood == 1)
	{
		echo "您已表达过了";
		exit;
	}
	$field = 'mood' . $mid;
	//查询是否有这个id
	$results = $pdo->query("select 1 from mood  where id='{$id}'");
	$row = $results->fetch(PDO::FETCH_ASSOC);
	if (is_array($row))
	{
		$query = $pdo->exec("update mood set " . $field . "=" . $field . "+1 where id=" . $id);
		if ($query)
		{
			setcookie("mood" . $id, $mid . $id, time() + 3600);
			$query2 = $pdo->query("select * from mood where id=$id");
			$rs = $query2->fetch(PDO::FETCH_ASSOC);
			$total = $rs['mood0'] + $rs['mood1'] + $rs['mood2'] + $rs['mood3'] + $rs['mood4'];
			$height = round(($rs[$field] / $total) * $moodpicheight);
			echo $height;
		}
		else
		{
			echo -1;
		}
	}
	else
	{
		$pdo->exec("INSERT INTO mood(id,mood0,mood1,mood2,mood3,mood4)VALUES ('{$id}','0','0','0','0','0')");
		$pdo->exec("update mood set " . $field . "=" . $field . "+1 where id=" . $id);
		setcookie("mood" . $id, $mid . $id, time() + 3600);
		echo $moodpicheight;
	}
}
else
{ //获取心情
	$mname = explode(',', $moodname);//心情说明
	$num = count($mname);
	$mpic = explode(',', $moodpic);//心情图标
	$id = (int)$_GET['id'];
	$rss = $pdo->query("select * from mood where id=$id");
	$rs = $rss->fetch(PDO::FETCH_ASSOC);
	if ($rs)
	{
		$total = $rs['mood0'] + $rs['mood1'] + $rs['mood2'] + $rs['mood3'] + $rs['mood4'];
		for ($i = 0; $i < $num; $i++)
		{
			$field = 'mood' . $i;
			$m_val = intval($rs[$field]);
			$height = 0; //柱图高度
			if ($total && $m_val)
			{
				$height = round(($m_val / $total) * $moodpicheight); //计算高度
			}
			$arr[] = array(
				'mid' => $i,
				'mood_name' => $mname[$i],
				'mood_pic' => $mpic[$i],
				'mood_val' => $m_val,
				'height' => $height
			);
		}
		echo json_encode($arr);
	}
	else
	{
		for ($i = 0; $i < $num; $i++)
		{
			$arr[] = array(
				'mid' => $i,
				'mood_name' => $mname[$i],
				'mood_pic' => $mpic[$i],
				'mood_val' => 0,
				'height' => 0
			);
		}
		echo json_encode($arr);
	}
}

//验证是否提交过
function chk_mood($id)
{
	$cookie = isset($_COOKIE['mood' . $id]) ? $_COOKIE['mood' . $id] : null;
	if ($cookie)
	{
		$doit = 1;
	}
	else
	{
		$doit = 0;
	}
	return $doit;
}

?>