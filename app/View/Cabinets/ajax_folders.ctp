<!------------------------------------------------------ 
    Tree View Explorer - start 
------------------------------------------------------->
<div id="explorer">
    <ul id="explorer_tree">
        <?php 
            $this->loadHelper("TreeViews");
            echo $this->TreeViews->createTree($treeFolders,array('action'=>'#')); 
        ?>
    </ul>
</div>
<!------------------------------------------------------ 
    Tree View Explorer - end 
------------------------------------------------------->


