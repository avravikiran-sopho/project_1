$.ajax({
    type: "GET",
    url: "action.php",
    data: {
        me: me
    },
    success: function (data) {
        alert(data);

    }
});