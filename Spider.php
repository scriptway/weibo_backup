<?php

namespace spider;
class Spider
{
    public static $header = CONFIGS['header'];

    /**
     * curl 发送请求
     * @param string $url
     * @param array $header
     * @return string 获取的数据数据流
     */
    public static function requests(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, self::$header);
        $raw = curl_exec($ch);
        curl_close($ch);
        return $raw;
    }


    /**
     * 请求长微博文字
     * @param string $mblogid 微博id
     * @return string 返回长微博内容
     */
    public static function getLongText(string $mblogid)
    {
        $url = 'https://weibo.com/ajax/statuses/longtext?id=' . $mblogid;
        $raw = self::requests($url);
        $text = json_decode($raw, true)['data']['longTextContent']; //提取长文本内容
        return $text;
    }


    /**
     * 图片下载
     * @param string $mblogid 微博id作为文件夹名字
     * @param string $pic_id 图片id
     * @param string $pic_url 图片url
     */
    public static function picDownload(string $mblogid, string $pic_id, string $pic_url)
    {
        if (CONFIGS['pic']['one_dir']) { //判断保存到一个文件夹还是根据微博ID新建文件夹保存
            $file_path = CONFIGS['pic']['path'];
        } else {
            $file_path = CONFIGS['pic']['path'] . $mblogid . '/';
        }
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }
        $file_name = $pic_id . '.jpg';
        $data = self::requests($pic_url);
        file_put_contents($file_path . $file_name, $data);
        echo "图片:{$file_path}{$file_name}  下载完成\n";
        echo "休眠".CONFIGS['pic_downloader_sleep']."秒\n";
        sleep(CONFIGS['pic_downloader_sleep']);
    }


}