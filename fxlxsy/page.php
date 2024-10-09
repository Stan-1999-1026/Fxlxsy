<?php
//为了避免重复包含文件而造成错误，加了判断函数是否存在的条件：
if (!function_exists('paging')) {
    //定义函数paging(),三个参数的含义为：
    //$total：记录总数；
    //$displayPG：每页显示记录数；
    //$url：分页导航中的链接，除了加入不同的查询信息“page”外的部分都与这个URL相同。
    //默认值本该设为本页URL（即$_SERVER["REQUEST_URI"]），但设置默认值的右边只能为常量，所以该默认值设为空字符串，在函数内部再设置为本页URL。
    function paging($total, $displayPG, $url = '')
    {
        //定义几个全局变量：
        //$firstCount：（数据库）查询的起始项；
        //$pageNav：页面导航条代码，函数内部并没有将它输出；
        global $firstCount, $pageNav;
        //定义全局变量，除了用global声明以外，还可以使用$GLOBALS["firstCount"] = 5这种方式来定义。然后在函数外面，就可以使用$firstCount了。
        $page = $_GET['page'] ?? 1;
        //如果$url使用默认，即空值，则赋值为本页URL：
        if (!$url) {
            $url = $_SERVER["REQUEST_URI"];
        }
        //URL分析：
        $parse_url = parse_url($url);
        $url_query = $parse_url["query"] ?? ''; //单独取出URL的查询字串
        if ($url_query) {
            //因为URL中可能包含了页码信息，我们要把它去掉，以便加入新的页码信息。
            //这里用到了正则表达式
            $url_query = preg_replace("/(^|&)page=$page/", "", $url_query);
            //将处理后的URL的查询字串替换原来的URL的查询字串：
            $url = str_replace($parse_url["query"], $url_query, $url);
            //在URL后加page查询信息，但待赋值：
            if ($url_query) $url .= "&page"; else $url .= "page";
        } else {
            $url .= "?page";
        }
        $last_page = ceil($total / $displayPG); //最后页，也是总页数
        $page = min($last_page, $page);
        $pre_page = $page - 1; //上一页
        $next_page = ($page == $last_page ? 0 : $page + 1); //下一页
        $firstCount = ($page - 1) * $displayPG;
        //开始分页导航条代码：
        $pageNav = "第 <B>" . ($total ? ($firstCount + 1) : 0) . "</B>-<B>" . min($firstCount + $displayPG, $total) . "</B> 条，共<B> $total </B>条记录";
        //如果只有一页则跳出函数：
        if ($last_page <= 1) return false;
        $pageNav .= " <a href=$url=1 >首页</a> ";
        if ($pre_page) $pageNav .= " <a href=$url=$pre_page >上页</a> "; else $pageNav .= " 上页 ";
        if ($next_page) $pageNav .= " <a href=$url=$next_page >下页</a> "; else $pageNav .= " 下页 ";
        $pageNav .= " <a href=$url=$last_page>尾页</a> ";
        //下拉跳转列表，循环列出所有页码：
        $pageNav .= "  到第 <select name='topage' size='1'  style='font-size:12px' onchange='window.location=\"$url=\"+this.value'>\n";
        for ($i = 1; $i <= $last_page; $i++) {
            if ($i == $page) $pageNav .= "<option value='$i' selected>$i</option>\n";
            else $pageNav .= "<option value='$i'>$i</option>\n";
        }
        $pageNav .= "</select> 页，共 $last_page 页";
    }
}

