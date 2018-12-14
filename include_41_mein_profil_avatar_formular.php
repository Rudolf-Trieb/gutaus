<script>
	$(document).ready(function(){
		
		// Ajax File upload with jQuery and XHR2
		// Sean Clark http://square-bracket.com
		// xhr2 file upload
		// data is optional
		$.fn.upload = function(remote,data,successFn,progressFn) {
			// if we dont have post data, move it along
			if(typeof data != "object") {
				progressFn = successFn;
				successFn = data;
			}
			return this.each(function() {
				if($(this)[0].files[0]) {
					var formData = new FormData();
					formData.append($(this).attr("name"), $(this)[0].files[0]);
	 
					// if we have post data too
					if(typeof data == "object") {
						for(var i in data) {
							formData.append(i,data[i]);
						}
					}
	 
					// do the ajax request
					$.ajax({
						url: remote,
						type: 'POST',
						xhr: function() {
							myXhr = $.ajaxSettings.xhr();
							if(myXhr.upload && progressFn){
								myXhr.upload.addEventListener('progress',function(prog) {
									var value = ~~((prog.loaded / prog.total) * 100);
	 
									// if we passed a progress function
									if(progressFn && typeof progressFn == "function") {
										progressFn(prog,value);
	 
									// if we passed a progress element
									} else if (progressFn) {
										$(progressFn).val(value);
									}
								}, false);
							}
							return myXhr;
						},
						data: formData,
						dataType: "json",
						cache: false,
						contentType: false,
						processData: false,
						complete : function(res) {
							var json;
							try {
								json = JSON.parse(res.responseText);
							} catch(e) {
								json = res.responseText;
							}
							if(successFn) successFn(json);
						}
					});
				}
			});
		};

		
		$("#avatar_loeschen").click(function(){
			$("#inhalt").load("include_41_mein_profil_avatar_loeschen.php");
			$("#avatar_icon").html("<img  style='height:77px' src='avatare/annonym.jpg'/>");
			return false;

		});		

		$("#avatar_hochladen").click(function(){
			$("#myfile").upload("include_41_mein_profil_avatar_hochladen.php",
								function(data){
									$("#inhalt").html(data);
									$("#avatar_icon").load("avatar_icon.php");
								},
								$("#prog")
						);
		});
		
		$(document).delegate('#myfile', 'change', function() {
			
			$("#myfile").upload("include_41_mein_profil_avatar_hochladen.php",
								function(data){
									$("#inhalt").html(data);
									$("#avatar_icon").load("avatar_icon.php");
								},
								$("#prog")
						);
						
		});
	
	
	});
</script>

<?php
	echo "<form ".
		 "style=\"float:left;\"".
		 " name=\"Avatar\" ".
		 " method=\"post\" ".
		 " enctype=\"multipart/form-data\" ".
		 " accept-charset=\"ISO-8859-1\">\n";
		 
//	echo "<span style=\"font-weight:bold;\" ".
//		 " title=\"max. 4MB\nmax 4000x40000 Pixel\n .jpg .gif oder .png wird auf 210 Pixel verkleinert\">\n".
//		 "Avatar :\n".
//		 "</span>\n";
		 
	if($row['Avatar']=='')
		echo "Kein Avatar vorhanden.\n";
	else
		echo "<img src=\"avatare/".htmlentities($row['Avatar'], ENT_QUOTES)."\">\n";
	if($row['Avatar']=='') {
		echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".(40*1024*1024)."\">";
		echo "<input id='myfile' name=\"pic\" type=\"file\">\n";
		echo "<a id='avatar_hochladen' href='#'>Avatar hochladen</a>\n";
		echo "<progress id='prog' value='0' min='0' max='100'></progress>";
	}
	else
		echo "<br><a id='avatar_loeschen' href='#' >Avatar l&ouml;schen</a>\n";
	echo "</form>\n";			
?>