function deleteHandle(event) {
    // 一旦フォームをストップ
    event.preventDefault();
    if (window.confirm("Are you sure to delete this post?")) {
        // 削除OKならformを再開
        document.getElementById("delete-form").submit();
    } else {
        alert("Canceled");
    }
}

function deleteReply(event, reply_id) {
    // 一旦フォームをストップ
    event.preventDefault();
    if (window.confirm("Are you sure to delete this reply?")) {
        // 削除OKならformを再開
        document.getElementById("delete-form" + reply_id).submit();
    } else {
        alert("Canceled");
    }
}
