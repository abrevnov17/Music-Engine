function changeImage(id,url) {
	var audio = document.getElementById("currentSong"); 
	document.getElementById("currentSong").src = url;

	if (document.getElementById(id).style.backgroundImage === 'url("images/pauseButton.png")') 
	{
		document.getElementById(id).style.backgroundImage = "url('images/playButton.png')";
		audio.pause();
	}
    else 
    {
        document.getElementById(id).style.backgroundImage = "url('images/pauseButton.png')";
        audio.play();
    } 

}

function openPopUp(){
	document.getElementById("pop-up").style.display = "block";
	//consider keeping opacity of upload-track button at 0.5
}

function closePopUp(){
	document.getElementById("pop-up").style.display = "none";
}

function changeColor(id){
	//document.getElementsByClassName("leftButton").style.backgroundColor = "none";
	console.log(id)
	document.getElementById(id).style.backgroundColor = "#0e83cd";
	
	var elements = document.getElementsByClassName("leftButton");
	for(var i = 0; i < elements.length; i++)
	{
   		if (elements[i].id != id){
   			elements[i].style.backgroundColor = "#2ac56c";
   		}
	}
}

function setInitialCategory(categoryID){
	
	if (categoryID != ""){
		changeColor(categoryID);	
	}

}

function changeLikeImage(track_id) {
    
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	var str1 = "like-button";
			var res = str1.concat(track_id);
            if (document.getElementById(res).style.backgroundImage === 'url("images/unlikeButton.png")'){
            	document.getElementById(res).style.backgroundImage = "url('images/likeButton.png')";
            }
            else{
            	document.getElementById(res).style.backgroundImage ="url('images/unlikeButton.png')";
            }
        }
    };
    xmlhttp.open("GET","likeOrUnlikeTrack.php?q="+track_id,true);
    xmlhttp.send();
}

function likeImageInitialToUnlike(id){
	document.getElementById(id).style.backgroundImage = "url('images/unlikeButton.png')";
}

function likeImageInitialToLike(id){
	document.getElementById(id).style.backgroundImage = "url('images/likeButton.png')";
}