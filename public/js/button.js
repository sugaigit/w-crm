document.getElementById("hidden").style.display ="none";

function clickBtn1(){
	const hidden = document.getElementById("hidden");

	if(hidden.style.display=="block"){
		// noneで非表示
		hidden.style.display ="none";
	}else{
		// blockで表示
		hidden.style.display ="block";
	}
}
