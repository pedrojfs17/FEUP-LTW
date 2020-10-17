<form action="action_add_news.php" method="post">
    <h2>Add News</h2>
    <input type="hidden" name="id" value="<?=$id?>">
    <label>Title 
        <input type="text" name="title">
    </label>
    <label>Tags 
        <input type="text" name="tags">
    </label>
    <label>Introduction
        <textarea name="introduction" cols="37" rows="4"></textarea>
    </label>
    <label>Full Text
        <textarea name="fulltext" cols="37" rows="40"></textarea>            
    </label>
    <input type="submit" value="Submit">
</form>