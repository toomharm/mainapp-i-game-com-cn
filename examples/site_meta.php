<?php

class SiteMetaManager
{
    private array $metaItems = [];

    public function __construct()
    {
        $this->metaItems = [
            [
                'url' => 'https://mainapp-i-game.com.cn',
                'title' => '爱游戏主站',
                'keywords' => ['爱游戏', '游戏平台', '在线娱乐'],
                'description' => '提供丰富的游戏内容和社区互动服务',
            ],
            [
                'url' => 'https://mainapp-i-game.com.cn/about',
                'title' => '关于爱游戏',
                'keywords' => ['爱游戏', '公司介绍', '团队文化'],
                'description' => '了解爱游戏背后的团队与使命',
            ],
            [
                'url' => 'https://mainapp-i-game.com.cn/contact',
                'title' => '联系爱游戏',
                'keywords' => ['爱游戏', '联系方式', '客服支持'],
                'description' => '获取爱游戏客服与商务合作联系方式',
            ],
        ];
    }

    public function addMetaItem(string $url, string $title, array $keywords, string $description): void
    {
        $this->metaItems[] = [
            'url' => $url,
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
        ];
    }

    public function getMetaItems(): array
    {
        return $this->metaItems;
    }

    public function generateShortDescription(string $url): string
    {
        foreach ($this->metaItems as $item) {
            if ($item['url'] === $url) {
                $kwList = implode(', ', $item['keywords']);
                $text = '站点：' . $item['title'] . ' | 关键词：' . $kwList . ' | ' . $item['description'];
                return mb_substr($text, 0, 100);
            }
        }
        return '未找到对应页面描述';
    }

    public function generateAllShortDescriptions(): array
    {
        $result = [];
        foreach ($this->metaItems as $item) {
            $result[$item['url']] = $this->generateShortDescription($item['url']);
        }
        return $result;
    }

    public function renderHtmlMetaTable(): string
    {
        $html = '<table border="1" cellpadding="8" cellspacing="0">';
        $html .= '<tr><th>URL</th><th>标题</th><th>描述摘要</th></tr>';
        foreach ($this->metaItems as $item) {
            $escapedUrl = htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8');
            $escapedTitle = htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8');
            $desc = htmlspecialchars($this->generateShortDescription($item['url']), ENT_QUOTES, 'UTF-8');
            $html .= "<tr><td>{$escapedUrl}</td><td>{$escapedTitle}</td><td>{$desc}</td></tr>";
        }
        $html .= '</table>';
        return $html;
    }
}

$manager = new SiteMetaManager();

$manager->addMetaItem(
    'https://mainapp-i-game.com.cn/faq',
    '爱游戏常见问题',
    ['爱游戏', 'FAQ', '帮助中心'],
    '解答爱游戏用户常见疑问与操作指南'
);

$allDescs = $manager->generateAllShortDescriptions();
foreach ($allDescs as $url => $desc) {
    echo "URL: " . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "\n";
    echo "描述: " . htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') . "\n\n";
}

echo "\n--- HTML 表格输出 ---\n";
echo $manager->renderHtmlMetaTable();