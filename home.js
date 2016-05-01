var nameList = ["home", "assignments", "schedule", "groups"];

function showTab(num){
	for(var i=1;i<=nameList.length;i++){
		document.getElementById("tab" + i).className = "tabs";
		document.getElementById(nameList[i - 1]).style.display = "none";
	}
	document.getElementById("tab" + num).className = "uptab";
	document.getElementById(nameList[num - 1]).style.display = "block";
}

function urlTab(){
	var locale = location.href;
	var currentTab = locale.substr(locale.indexOf("#") + 1);
	if (nameList.indexOf(currentTab) > -1){
		var IDnum = nameList.indexOf(currentTab);
		showTab(IDnum + 1);
	}
	else{
		showTab(1);
	}
}