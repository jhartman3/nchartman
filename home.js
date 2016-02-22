var nameList = ["home", "assign", "schedule", "groups"];

function showTab(num){
	for(var i=1;i<=nameList.length;i++){
		document.getElementById("tab" + i).className = "tabs";
		document.getElementById(nameList[i - 1]).style.display = "none";
	}
	document.getElementById("tab" + num).className = "uptab";
	document.getElementById(nameList[num - 1]).style.display = "block";
}