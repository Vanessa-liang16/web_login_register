document.addEventListener('DOMContentLoaded', function() {

    fetch('get_message.php')
    .then(response => response.json())
    .then(data => {
        // 处理数据
    })
    .catch(error => {
        console.error('Error:', error);
    });

});
