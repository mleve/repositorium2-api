function lalala(){
	
	var pag = $(this).attr("id");
	var url;
	
	switch(pag)
	{
	case "console":
		url = "console.php";
		break;
	case "what":
		url = "what.html";
		break;
	case "how":
		url = "how.html";
		break;
	case "contact":
		url = "contact.html";
		break;
	}
	
	$.ajax({
		url: url,
		type: "GET"
	}).done(function(console){
		$("#mainContainer").html(console);
	});
	
}


$("#console").on("click", lalala);
$("#what").on("click", lalala);
$("#how").on("click", lalala);
$("#contact").on("click", lalala);
