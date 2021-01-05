<?php
$json = file_get_contents('php://input');
$page = file_get_contents('link.php');

if ($json) {
    $array = json_decode($json, true);
    $link = array_pop($array);
    file_put_contents('link.php', $link);
    file_put_contents('page.php', $array, FILE_APPEND);
}

function content($page)
{
    if (!empty($page)) {
        $url = $page;
    } else {
        $url = 'https://www.kolesa.ru/news';
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, $url);
    curl_exec($ch);
    curl_close($ch);
}

content($page);
?>


<script>
    window.onload = function() {
        const elem = document.querySelector('.post-list')
        const content = []
        const pages = document.querySelectorAll('.page-item')
        let page

        function parser(elem) {
            elem.childNodes.forEach(node => {
                if (node.nodeName === 'A') {
                    content.push(node.innerHTML.match(/https.+g/)[0])
                } else {
                    parser(node)
                }
            })
        }

        function getPage() {
            pages.forEach(node => {
                if (node.classList[1] === 'active') {
                    page = node.nextSibling
                    if (page.nodeName === '#text') {
                        page = page.nextSibling
                    }
                }
            })
        }

        parser(elem)
        getPage()

        content.push(page.firstChild.getAttribute('href'))

        fetch('http://php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(content)
            })
            .then(() => {
                // window.location.href = 'http://php'
            })
    }
</script>