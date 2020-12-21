<?php

namespace spider;
class Parser
{
    /**
     * 返回全部页数的url数组
     * @return array
     */
    public static function pageParser()
    {
        $total = CONFIGS['total'];
        $per = CONFIGS['per'];
        $page_num = ceil($total / $per);
        $root_url = "https://weibo.com/ajax/statuses/mymblog?uid=".CONFIGS['userid']."&page=";
        $page_urls = [];
        for ($i=1;$i<=$page_num;$i++){
            $url = $root_url.$i;
            array_push($page_urls,$url);
        }
        return $page_urls;
    }


    /**
     *  传入json里的list数组 解析单条微博数据 插入数据库 保存图片
     * @param array $list json里的list数组
     */
    public static function oneWbParser(array $list)
    {
        $userid = CONFIGS['userid'];
        $visible = $list['visible']['type']?:0; //0公开 1自己可见 6好友圈可见
        $created_at = $list['created_at'];//创建日期
        $text_raw = $list['text_raw'];//原始文本（包含空格换行等）
        $text = $list['text'];//带HTML标签的文本
        $mblogid = $list['mblogid'];//单条微博的id  Jxy7Ek5Mw
        $source = $list['source'];//发布设备
        $attitudes_count = $list['attitudes_count']; //点赞数
        $reads_count = $list['reads_count']?:0; //阅读数
        $comments_count = $list['comments_count']; //评论数
        $pic_num = $list['pic_num']; //int 图片数量

        echo "单条微博ID:{$mblogid}\n";
        echo "发布设备:{$source}\n";
        echo "发布日期:{$created_at}\n";
        echo "微博内容:{$text_raw}\n";

        //这里需要判断一下是否有长文本 true的话需要去 https://weibo.com/ajax/statuses/longtext?id=$mblogid 请求
        if ($list['isLongText']) { //true | false
            $long_text = Spider::getLongText($mblogid);
            echo "长微博内容:{$long_text}\n";
        }

        echo "阅读数:{$reads_count}\n";
        echo "点赞数:{$attitudes_count}\n";
        echo "评论数:{$comments_count}\n";
        echo "图片数量:{$pic_num}\n";

        //图片id数组
        if (!empty($list['pic_ids'])) {
            $pic_ids = self::picIdsParser($list['pic_ids']);
        }
        //保存图片 路径 ./img/$mblogid/$pic_id.jpg
        if (!empty($list['pic_infos'])) {
            $pic_urls = self::picInfosParser($list['pic_infos']);
            foreach ($pic_urls as $k => $pic_url){
                echo "正在下载图片:{$pic_url}\n";
                Spider::picDownload($mblogid,$pic_ids[$k],$pic_url);
            }
            //转成字符串
            $pic_ids = implode(',', $pic_ids);
            $pic_urls = implode(',', $pic_urls);
        }

        echo "正在写入数据库....\n";
        $sql = "insert into t1 values (null, $userid,$visible,'$mblogid','$created_at','$text_raw','$text','$long_text','$source',$attitudes_count,$reads_count,$comments_count,$pic_num,'$pic_ids','$pic_urls')";
        $db = new SaveToDB();
        $db->insert($sql);
    }


    /**
     * 遍历pic_ids数组 返回图片id数组
     * @param array $pic_ids
     * @return array
     */
    public static function picIdsParser(array $pic_ids)
    {
        $id = [];
        foreach ($pic_ids as $idRaw) {
            array_push($id, $idRaw);
        }
        return $id;
    }

    /**
     * 遍历pic_infos数组 返回图片url数组
     * @param array $pic_infos
     * @return array
     */
    public static function picInfosParser(array $pic_infos)
    {
        $original_pic_url = [];
        foreach ($pic_infos as $pic) {
            array_push($original_pic_url, $pic['original']['url']);
        }
        return $original_pic_url;
    }


}