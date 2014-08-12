<?php
needLogin();
if(hasFlag("help")){
    echo "findvideo用于通过标题查找视频\n     <b>findvideo 标题</b>\n此命令使用正则匹配查找，你可以直接输入标题或者一部分，或者使用正则表达式";
    exit;
}
$option = $options;
header("Content-Type:text/html", true);
if (@$option[0]) {
    if (connectSQL()) {
        Global $SQL;
        $stmt = mysqli_stmt_init($SQL);
        mysqli_stmt_prepare($stmt, "SELECT id,title,address,count FROM video WHERE title REGEXP ?");
        mysqli_stmt_bind_param($stmt, "s", $option[0]);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt,$id,$title,$address, $count);
        echo "<table>";
            out("<tr><th>ID</th><th>播放数</th><th>标题</th><th>地址</th></tr>");
        while(mysqli_stmt_fetch($stmt)){
            out("<tr><td>".$id."</td><td>".$count."</td><td>".$title."</td><td>".$address."</td></tr>");
        }
        echo "</table>";
       out("查找完毕,共".$stmt->num_rows."条");
        }
        else{
        	echo "Error";
                return;
        }
} else {
    echo "Error";
}
exit;
?>