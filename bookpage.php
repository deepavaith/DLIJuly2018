<?php
$Id=$_GET['Id'];
echo $GoogleId;
?>
<html>
	<head>
		<?php include "conn.php"; include "header.php"; ?>
	</head>
	<body>
		<div class="col-md-12" style="padding-left:0px">
			<div class="col-md-8" style="padding-left:0px">
				<iframe src="https://docs.google.com/viewer?srcid=<?php echo $Id;?>&pid=explorer&efh=false&a=v&chrome=false&embedded=true" width="100%" style="height: 98vh;"></iframe>
			</div>
			<div class="col-md-2">
				<?php
					$sql="SELECT * FROM books WHERE google_drive_id='".$Id."'";
					//echo $sql;
					$result = mysqli_query($conn,$sql);
					$row=mysqli_fetch_assoc($result);
					//print_r($row);
				?>
				<ul class="ul-list">
					<li><div class="flex-div"><span>Title:</span><span><?php echo $row['dc_title'];?></span></div></li>
					<li><div class="flex-div"><span>Author:</span><span><?php echo strtoupper($row['dc_contributor_author']);?></span></div></li>
					<li><div class="flex-div"><span>Other contributors:</span><span><?php echo $row['dc_contributor_other'];?></span></div></li>
					<li><div class="flex-div"><span>Publisher:</span><span><?php echo strtoupper($row['dc_publisher']);?></span></div></li>
					<li><div class="flex-div"><span>Source library:</span><span><?php echo strtoupper($row['dc_source_library']);?></span></div></li>
					<li><div class="flex-div"><span># pages:</span><span><?php echo $row['dc_description_totalpages'];?></span></div></li>
					<li><div class="flex-div"><span>Barcode:</span><span><?php echo $row['dc_identifier_barcode'];?></span></div></li>
					<li><div class="flex-div"><span>Language:</span><span><?php echo $row['dc_language_iso'];?></span></div></li>
					<li><div class="flex-div"><span>Date accessioned:</span><span><?php echo $row['dc_date_accessioned'];?></span></div></li>
					<li><div class="flex-div"><span>Date available:</span><span><?php echo $row['dc_date_available'];?></span></div></li>
					<li><div class="flex-div"><span>Citation date:</span><span><?php echo $row['dc_date_citation'];?></span></div></li>
					<li><div class="flex-div"><span>Copyright expiry date:</span><span><?php echo $row['dc_date_copyrightexpirydate'];?></span></div></li>
					<li><div class="flex-div"><span>Digital publication date:</span><span><?php echo $row['dc_date_digitalpublicationdate'];?></span></div></li>
					<li><div class="flex-div"><span>ERNET URI:</span><span><?php echo $row['dc_description_alternateuri'];?></span></div></li>
					<li><div class="flex-div"><span>Description:</span><span><?php echo $row['dc_description_main'];?></span></div></li>
					<li><div class="flex-div"><span>Description numbered pages:</span><span><?php echo $row['dc_description_numberedpages'];?></span></div></li>
					<li><div class="flex-div"><span>Scanner number:</span><span><?php echo $row['dc_description_scannerno'];?></span></div></li>
					<li><div class="flex-div"><span>Scaning centre:</span><span><?php echo $row['dc_description_scanningcentre'];?></span></div></li>
					<li><div class="flex-div"><span>Location:</span><span><?php echo $row['dc_description_slocation'];?></span></div></li>
					<li><div class="flex-div"><span>Tagged:</span><span><?php echo $row['dc_description_tagged'];?></span></div></li>
					<li><div class="flex-div"><span>Vendor:</span><span><?php echo $row['dc_description_vendor'];?></span></div></li>
					<li><div class="flex-div"><span>MIME type:</span><span><?php echo $row['dc_format_mimetype'];?></span></div></li>
					<li><div class="flex-div"><span>DC identifier:</span><span><?php echo $row['dc_identifier'];?></span></div></li>
					<li><div class="flex-div"><span>Copy number:</span><span><?php echo $row['dc_identifier_copyno'];?></span></div></li>
					<li><div class="flex-div"><span>Original path:</span><span><?php echo $row['dc_identifier_origpath'];?></span></div></li>
					<li><div class="flex-div"><span>Identifier URI:</span><span><?php echo $row['dc_identifier_uri'];?></span></div></li>
					<li><div class="flex-div"><span>Digital republisher:</span><span><?php echo $row['dc_publisher_digitalrepublisher'];?></span></div></li>
					<li><div class="flex-div"><span>Rights:</span><span><?php echo $row['dc_rights'];?></span></div></li>
					<li><div class="flex-div"><span>Rights holder:</span><span><?php echo $row['dc_rights_holder'];?></span></div></li>
					<li><div class="flex-div"><span>Subject classification:</span><span><?php echo $row['dc_subject_classification'];?></span></div></li>
					<li><div class="flex-div"><span>Subject keywords:</span><span><?php echo $row['dc_subject_keywords'];?></span></div></li>
					<li><div class="flex-div"><span>Filename:</span><span><?php echo $row['filename'];?></span></div></li>
				</ul>
			</div>
		</div>
	</body>
	<style>
	.flex-div{flex-flow: column nowrap;display: flex;padding-bottom: 13px}
	.ul-list{list-style:none;padding:0px;margin-top: 10px;}
	.flex-div > :first-child {font-size: 18px;color: rgba(0,0,0,.87);font-weight: 500;}
	.flex-div > :nth-child(2), .flex-div > :nth-child(3){color:rgba(0,0,0,.6);font-size:14px;font-weight: normal;}
	</style>
</html>
