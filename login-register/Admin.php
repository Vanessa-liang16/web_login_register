<?php
session_start();

require_once('database.php');
$query="SELECT full_name,gender,email,color FROM users";
$result=mysqli_query($conn,$query);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <!-- 頂部導航欄 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#memberTable" aria-expanded="false" aria-controls="memberTable" data-section="memberTable">會員列表</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#userChange" aria-expanded="false" aria-controls="userChange" data-section="userChange">修改個人資料</a>
                        
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#file" aria-expanded="false" aria-controls="file">檔案總管</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#chatBoard" aria-expanded="false" aria-controls="chatBoard">留言板</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#subscribe" aria-expanded="false" aria-controls="subscribe">訂閱</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#manage" aria-expanded="false" aria-controls="manage">會員管理</a>
                    </li>
                </ul>
                <span class="navbar-text me-3">
                <?php
                    // 如果用户已登录，显示用户名
                    if (isset($_SESSION['username'])) {
                        echo htmlspecialchars($_SESSION['username']);
                    } else {
                        echo 'Hello,Admin'; // 或者不显示任何东西
                    }
                    ?>
                </span>
                <a class="btn btn-outline-danger" href="login.php">登出</a>
            </div>
        </div>
    </nav>

    <!-- 會員管理摺疊區域 -->
    <div class="container mt-4">
        <div class="collapse" id="manage">
            <h2>會員管理</h2>
            <!-- 搜索栏 -->
            <div class="mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="搜索會員">
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">會員名稱</th>
                        <th scope="col">執行時間</th>
                        <th scope="col">紀錄</th>
                    </tr>
                </thead>
                <<tbody id="logTableBody">
                <!-- 搜索结果会动态插入这里 -->
            </tbody>
            </table>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const logTableBody = document.getElementById('logTableBody');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value;
        fetch(`search_logs.php?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                logTableBody.innerHTML = '';
                data.forEach(row => {
                    logTableBody.innerHTML += `
                        <tr>
                            <td>${row.member_name}</td>
                            <td>${row.execution_time}</td>
                            <td>${row.record}</td>
                        </tr>
                    `;
                });
            });
    });
});
</script>

    <!-- 會員資料表格摺疊區域 -->
    <div class="container mt-4">
        <div class="collapse" id="memberTable">
            <h2>會員資料</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">姓名</th>
                        <th scope="col">性別</th>
                        <th scope="col">電子郵件</th>
                        <th scope="col">喜好顏色</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        while($row=mysqli_fetch_assoc($result))
                        {
                            $color = htmlspecialchars($row['color']);
                        ?>
                        <td><?php echo $row['full_name'];  ?></td>
                        <td><?php echo $row['gender'];  ?></td>
                        <td><?php echo $row['email'];  ?></td>
                        <td><?php echo $row['color'];  ?></td>
                        <td>
                            <span style="background-color: <?php echo $color; ?>; display: inline-block; width: 20px; height: 20px; border-radius: 50%;"></span>
                            
                        </td>

                        </tr>
                        <?php
                        }
                        
                        ?>
                    
                </tbody>
            </table>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <!-- 會員修改資料摺疊區域 -->
    <?php
        //session_start();
        require_once('database.php');
    ?>
    <div class="container mt-4">
        <div class="collapse" id="userChange">
            <h2>資料修改</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">姓名</th>
                        <th scope="col">性別</th>
                        <th scope="col">電子郵件</th>
                        <th scope="col">喜好顏色</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            require_once('database.php');

                            // 假设要显示 id 为 4 的用户数据
                            $id = 1;  // 这里指定要查询的 id

                            // 准备查询语句
                            $sql = "SELECT * FROM users WHERE id=?";
                            $stmt = mysqli_prepare($conn, $sql);

                            // 绑定参数并执行查询
                            mysqli_stmt_bind_param($stmt, 'i', $id);
                            mysqli_stmt_execute($stmt);

                            // 获取结果
                            $result = mysqli_stmt_get_result($stmt);
                            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

                            // 检查是否找到了对应的用户
                            if ($user) {
                                // 动态填充数据到表格
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($user['full_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($user['gender']) . '</td>';
                                echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                                echo '<td>' . htmlspecialchars($user['color']) . '</td>';
                                echo '</tr>';
                            } else {
                                // 如果没有找到对应的记录，显示一个提示
                                echo '<tr><td colspan="4">No data found for this ID</td></tr>';
                            }

                            // 关闭连接
                            mysqli_stmt_close($stmt);
                            mysqli_close($conn);
                            ?>
                        <td>
                        <a href="edit.php?id=1" class="btn btn-primary">Edit</a>
                        </td>
                   
                    
                </tbody>
            </table>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!--檔案編輯區域-->
    <div class="container mt-4">
    <div class="collapse" id="file">
        <h2>檔案管理和上傳</h2>
        
        <!-- Upload Form -->
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file" class="form-label">Upload File</label>
                <input class="form-control" type="file" id="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    
        <!-- Alert Message -->
        <div id="alertMessage" class="alert alert-danger mt-3 d-none"></div>
    
        <!-- Files Table -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th scope="col">File Name</th>
                    <th scope="col">File Size</th>
                    <th scope="col">Upload Time</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="filesTableBody">
                <!-- File records will be injected here by JavaScript -->
            </tbody>
        </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('uploadForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    loadFiles();
                    document.getElementById('alertMessage').classList.add('d-none');
                } else {
                    document.getElementById('alertMessage').classList.remove('d-none');
                    document.getElementById('alertMessage').innerText = data.message;
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function loadFiles() {
            fetch('get_files.php')
            .then(response => response.json())
            .then(data => {
                var filesTableBody = document.getElementById('filesTableBody');
                filesTableBody.innerHTML = '';
                data.files.forEach(file => {
                    var row = `<tr>
                        <td>${file.filename}</td>
                        <td>${file.filesize}</td>
                        <td>${file.upload_time}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="downloadFile('${file.filename}')">Download</button>
                            <button class="btn btn-sm btn-secondary" onclick="renameFile('${file.filename}')">Rename</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteFile('${file.filename}')">Delete</button>
                        </td>
                    </tr>`;
                    filesTableBody.insertAdjacentHTML('beforeend', row);
                });
            });
        }

        function downloadFile(filename) {
            window.location.href = 'uploads/' + filename;
        }

        function renameFile(filename) {
            var newFilename = prompt('Enter new filename:', filename);
            if (newFilename && newFilename !== filename) {
                fetch('rename_file.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ old_filename: filename, new_filename: newFilename })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        loadFiles();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }

        function deleteFile(filename) {
            if (confirm('Are you sure you want to delete this file?')) {
                fetch('delete_file.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ filename: filename })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        loadFiles();
                    } else {
                        alert(data.message);
                    }
                });
            }
        }

        // Load files when the page loads
        loadFiles();
    </script>

    <!--聊天室區域-->
    <div class="container mt-4">
    <div class="collapse" id="chatBoard">
        <h2>聊天室</h2>
        <form id="messageForm">
                <div class="mb-3">
                    <label for="messageTitle" class="form-label">標題</label>
                    <input type="text" class="form-control" id="messageTitle" required>
                </div>
                <div class="mb-3">
                    <label for="messageContent" class="form-label">內容</label>
                    <textarea class="form-control" id="messageContent" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">發佈消息</button>
            </form>
            <div id="messagesList" class="mt-4">
            </div>
        
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script src="chat.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const messageForm = document.getElementById('messageForm');
        const messagesList = document.getElementById('messagesList');

        // Load existing messages
        fetchMessages();

        messageForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const title = document.getElementById('messageTitle').value;
            const content = document.getElementById('messageContent').value;

            fetch('post_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ title, content })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchMessages(); // Reload messages
                    messageForm.reset(); // Reset form
                } else {
                    alert(data.error);
                }
            });
        });

        function fetchMessages() {
    fetch('get_message.php')
        .then(response => response.json())
        .then(data => {
            const currentUserId = Number(data.current_user_id); // 确保 currentUserId 是数字
            console.log('Current User ID:', currentUserId, 'Type:', typeof currentUserId);
            
            messagesList.innerHTML = data.messages.map(message => {
                // 将 message.author_id 转换为数字
                const messageAuthorId = Number(message.author_id);
                console.log('message.author_id:', messageAuthorId, 'Type:', typeof messageAuthorId);
                
                return `
                    <div class="message" data-id="${message.id}">
                        <h4>${message.title}</h4>
                        <p>${message.content}</p>
                        <small>Published by ${message.author_name} on ${message.created_at}</small>
                        <!-- Show reply button for all users -->
                        <button class="btn btn-secondary btn-sm" onclick="replyToMessage(${message.id})">Reply</button>
                        <!-- Show edit and delete buttons only if the user is the author -->
                        ${messageAuthorId === currentUserId ? `
                            <button class="btn btn-warning btn-sm" onclick="editMessage(${message.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteMessage(${message.id})">Delete</button>
                        ` : ''}
    
                        <div class="replies">
                            ${message.replies.length ? message.replies.map(reply => {
                                // 将 reply.author_id 转换为数字
                                const replyAuthorId = Number(reply.author_id);
                                console.log('reply.author_id:', replyAuthorId, 'Type:', typeof replyAuthorId);
                                
                                return `
                                    <div class="reply" data-id="${reply.id}">
                                        <p>${reply.content}</p>
                                        <small>Replied by ${reply.author_name} on ${reply.created_at}</small>
                                        <!-- Show edit and delete buttons for replies only if the user is the author -->
                                        ${replyAuthorId === currentUserId ? `
                                            <button class="btn btn-warning btn-sm" onclick="editReply(${reply.id})">Edit</button>
                                            <button class="btn btn-danger btn-sm" onclick="deleteReply(${reply.id})">Delete</button>
                                        ` : ''}
                                        <!-- Add reply button to each reply -->
                                        <button class="btn btn-secondary btn-sm" onclick="replyToReply(${reply.id})">Reply</button>
                                    </div>
                                `;
                            }).join('') : 'No replies yet'}
                        </div>
                    </div>
                `;
            }).join('');
            
        })
        .catch(error => console.error('Error fetching messages:', error));
}




        // Functions for handling replies, editing, and deleting
        window.replyToMessage = function(messageId) {
            const content = prompt("Enter your reply content:");
            if (content) {
                fetch('reply_to_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message_id: messageId, content: content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Reply added successfully!');
                        fetchMessages(); // Refresh messages and replies
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        };

        window.replyToReply=function(replyId){
            const content = prompt("Enter your reply content:");
            if (content) {
                fetch('reply_to_reply.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ reply_id: replyId, content: content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Reply added successfully!');
                        fetchMessages(); // Refresh messages and replies
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        };


        window.editMessage = function(messageId) {
        
        const newContent = prompt("Enter new content:");
        
        if (newContent) {
            fetch('edit_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: messageId, content: newContent })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Message updated successfully!');
                    fetchMessages();
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        };

        window.deleteMessage = function(messageId) {
            fetch('delete_message.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: messageId })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchMessages(); // Reload messages
                } else {
                    alert(data.error);
                }
            });
        };

        window.editReply = function(replyId) {
        const newContent = prompt("Enter new content:");
        
        if (newContent) {
            fetch('edit_reply.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: replyId, content: newContent })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Reply updated successfully!');
                    fetchMessages();
                } else {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }
        };



        window.deleteReply = function(replyId) {
            fetch('delete_reply.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: replyId })
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchMessages(); // Reload messages
                } else {
                    alert(data.error);
                }
            });
        };
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!--訂閱區域-->
    <div class="container mt-4">
        <div class="collapse" id="subscribe">
            <h2>訂閱區域</h2>
            <form id="subscriptionForm">
                <div class="form-group mb-3">
                
                </div>
                <button onclick="addImage(event)" type="submit" class="btn btn-primary">Subscribe</button>
            </form>
            
        </div>
        <br>
        <div id="imageContainer"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function addImage(event) {
        event.preventDefault(); // 防止表單提交
        
        // 創建新圖片元素
        var img = document.createElement('img');
        img.src = 'background.jpg'; // 圖片路徑
        img.alt = 'New Image'; // 圖片替代文字
        img.style.width = '100%'; // 設置圖片寬度
        img.style.height = 'auto'; // 設置圖片高度自動調整

        // 獲取圖片容器並新增圖片元素
        var imageContainer = document.getElementById('imageContainer');
        imageContainer.appendChild(img);

        alert('已訂閱');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var memberTable = document.getElementById('memberTable');
        var userChange = document.getElementById('userChange');
        var file = document.getElementById('file');
        var chatBoard = document.getElementById('chatBoard');
        var subscribe = document.getElementById('subscribe');

        var bsMemberTable = new bootstrap.Collapse(memberTable, {
            toggle: false
        });
        var bsUserChange = new bootstrap.Collapse(userChange, {
            toggle: false
        });
        var bsfile = new bootstrap.Collapse(file, {
            toggle: false
        });
        var bsChatBoard = new bootstrap.Collapse(chatBoard, {
            toggle: false
        });
        var bssubscribe = new bootstrap.Collapse(subscribe, {
            toggle: false
        });

        document.querySelector('a[href="#memberTable"]').addEventListener('click', function() {
            bsMemberTable.show();
            bsUserChange.hide();
            bsChatBoard.hide();
            bsfile.hide();
            bssubscribe.hide();

        });

        document.querySelector('a[href="#userChange"]').addEventListener('click', function() {
            bsUserChange.show();
            bsMemberTable.hide();
            bsChatBoard.hide();
            bsfile.hide();
            bssubscribe.hide();
        });

        document.querySelector('a[href="#file"]').addEventListener('click', function() {
            bsUserChange.hide();
            bsMemberTable.hide();
            bsChatBoard.hide();
            bsfile.show();
            bssubscribe.hide();
        });

        document.querySelector('a[href="#chatBoard"]').addEventListener('click', function() {
            bsChatBoard.show();
            bsMemberTable.hide();
            bsUserChange.hide();
            bsfile.hide();
            bssubscribe.hide();
        });

        document.querySelector('a[href="#subscribe"]').addEventListener('click', function() {
            bsUserChange.hide();
            bsMemberTable.hide();
            bsChatBoard.hide();
            bsfile.hide();
            bssubscribe.show();
        });

    });

</script>

</body>
</html>