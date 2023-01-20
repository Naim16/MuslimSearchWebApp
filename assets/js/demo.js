function getUser(value, user) {
	$.post("includes/handlers/ajax_friend_search.php", {query:value, userLoggedIn}, function(data){
		$(".results").html(data);
	});
}