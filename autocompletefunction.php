<?php
include 'conn.php';	
$From=$_GET['From'];
$Value=$_GET['Value'];
$return_arr = array(); 
if($From=="author"){
	$sql="SELECT dc_contributor_author FROM `books` WHERE LOWER(replace(dc_contributor_author,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' and dc_contributor_author<>'' GROUP BY LOWER(replace(dc_contributor_author,' ','')) limit 0,20";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		$newstr="";
		while($row=mysqli_fetch_array($result))
		{
			$newstr=$row['dc_contributor_author'];
			if (preg_match('/\..*\./', $row['dc_contributor_author'])){
				//echo "<br><br>yes".$row['dc_contributor_author']."<br>";
				$str1=substr($row['dc_contributor_author'],3,1);
				$str2=substr($row['dc_contributor_author'],2,1);
				//echo "str1".$str1."  str2".$str2."<br>";
				if(($str1==".")||($str1=="")){
					//echo "in str1 if<br>";
					if(($str2!="")&&($str2!=".")){
						//echo "in str2 if".strtoupper($str2)."<br>";
						$upperstr=strtoupper($str2);
						$newstr=substr_replace($row['dc_contributor_author'],$upperstr,2,1);
						//echo "newstr".$newstr."<br>";
					}
				}
			}else{
				$str1=substr($row['dc_contributor_author'],3,1);
				$str2=substr($row['dc_contributor_author'],2,1);
				if(($str1==".")||($str1=="")){
					if(($str2!="")&&($str2!=".")){
						$upperstr=strtoupper($str2);
						$newstr=substr_replace($row['dc_contributor_author'],$upperstr,2,1);
					}
				}
			}
						
			//echo "newstr".$newstr."<br>";
			
			$row_array['value'] = html_entity_decode(html_entity_decode(ucwords($newstr),ENT_QUOTES),ENT_QUOTES);
			$row_array['authorvalue'] = html_entity_decode(html_entity_decode($row['dc_contributor_author'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="subject"){
	$sql="SELECT dc_subject_keywords FROM `books` WHERE LOWER(replace(dc_subject_keywords,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' and dc_subject_keywords<>'' GROUP BY LOWER(replace(dc_subject_keywords,' ','')) limit 0,20";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_subject_keywords'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		//$row_array['id']="";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="title"){
	$sql="select dc_title from `books` where LOWER(replace(dc_title,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' and dc_title<>'' GROUP BY LOWER(replace(dc_title,' ','')) limit 0,20";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_title'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}
if($From=="institution"){
	$sql="SELECT dc_source_library FROM `books` WHERE LOWER(replace(dc_source_library,' ','')) like '%".strtolower(preg_replace('/\s+/', '', $_GET['term']))."%' and dc_source_library<>'' GROUP BY LOWER(replace(dc_source_library,' ','')) limit 0,20";
	$result = mysqli_query($conn,$sql);
	$numofrows=mysqli_num_rows($result);
	if($numofrows!=0)
	{
		while($row=mysqli_fetch_array($result))
		{
			$row_array['value'] = html_entity_decode(html_entity_decode($row['dc_source_library'],ENT_QUOTES),ENT_QUOTES);
			array_push($return_arr,$row_array);
		}
	}else{
		$row_array['value']="No data found";
		array_push($return_arr,$row_array);
	}	
	echo json_encode($return_arr);
}

?>
