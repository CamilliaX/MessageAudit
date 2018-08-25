<!DOCTYPE>
<html>
<head>
	<title>留言审核系统</title>
	<link rel="stylesheet" href="css/base.css" type="text/css">
	<script src="js/jquery.min.js"></script>
</head>
<body>
<div id="main">
	<div style="position: relative;"><h1>留言审核系统</h1>
		<?php
		    if(!$this->is_login())
		    {
		?>
		<div class="login"><a id="show-login" href="#">点击登陆</a></div>
		<div id="login-form" action="index.php" method="get">
	    <form>
	    <ul>
	    	<li><label>账号：</label><input type="text" name="name"></li>
	    	<input type="hidden" name="action" value="login">
	    	<li><label>密码：</label><input type="password" name="pwd"></li>
	    	<li><input type="submit" class="s-button" name="" value="登陆">
	    	<input type="button"  class="s-button" name="" value="取消" id="close-login"></li>
	    </ul>
	    </form>
		</div>

		<?php }else{ ?>
		<div class="login">欢迎你！<?php echo $_SESSION['user_name'] ?>&nbsp;<a href="index.php?action=loginout" style="color: #ffb6c1">登出</a></div>
		<?php  } ?>
	</div>
<form id="main-form" action="index.php" method="get">
	<label>昵称：<span class="text-danger">*</span></label>
	<input type="text" name="user">
	<input type="hidden" name="action" value="add">
	<label>内容：<span class="text-danger">*</span></label>
	<textarea name="content"></textarea>
	<input type="submit" name="" id="submit-button" class="s-button" value="发表">
</form>
<ul>
<?php
if($message){
foreach ($message as $link) {
?>
	<li class="message-item">
		<div class="message-indent"><div class="message-head">
	             <img src="/images/head.jpg">
        </div>
    <div class="message-user"> <?php echo $link['user_name']; ?>	</div>
<div class="message-meta"><span><?php echo $link['date']; ?></span></div>
<div class="message-text"><p>
<?php echo $link['content']; ?></p>
</div>
<?php
if($this->is_login()){
?>
<div id="edit">
	<a href="index.php?action=delete&id=<?php echo $link['id']; ?>">删除</a>
	<?php
	   if(!$link['view']){
	?>
	<a href="index.php?action=pass&id=<?php echo $link['id']; ?>" style="color: #f05050">点击通过审核</a>
    <?php
      }else{
      	echo '<a style="color: #00f7f">已通过审核</a>';
      }
    ?></div>
 <?php } ?>
</div>
 </li>
 <?php
}}
?>
</ul>
</div>
<script type="text/javascript" src="js/base.js"></script>
</body>
</html>