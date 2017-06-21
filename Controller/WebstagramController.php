<?php

namespace CTC\WebstagramBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;

class WebstagramController extends Controller
{


    public function viewAction($name = null, $template = null, $description = null, $maxItem = null)
    {

        $returnArray = array();

        $error = "";
        if(is_null($name)){
            $name = $this->container->getParameter('webstagram.defaultID');
        }

        if(is_null($template)){
            $template = '@CTCWebstagram/webstagram/view.html.twig';
        }

        if(is_null($maxItem)){
            $maxItem  = $this->container->getParameter('webstagram.front.maxItem');

        }

        $ressourcePath = $this->container->get('kernel')->locateResource("@CTCWebstagramBundle/Resources");

        $prefixUriFront = $this->container->getParameter('webstagram.front.urlPrefix');

        if(!empty($ressourcePath)){

            $ressourcePath .= '/public/xml';

            $xmlPath = $ressourcePath.'/'.$name.'.xml';

            if(file_exists($xmlPath)){

                $content = file_get_contents($xmlPath);

                $xml = simplexml_load_string($content);

                $i = 0;
                foreach ($xml->channel->item as $item){

                    if($i < $maxItem || $maxItem == 0){

                        $thumbAttr = $item->children('media', true)->thumbnail->attributes();

                        $url = $item->link;

                        $url_path = parse_url($url, PHP_URL_PATH);
                        $basename = pathinfo($url_path, PATHINFO_BASENAME);


                        $returnArray[$i]['key']         = $i;
                        $returnArray[$i]['title']       = $item->title;
                        $returnArray[$i]['url']         = $prefixUriFront.$basename;
                        $returnArray[$i]['defaultUri']  = $item->link;
                        $returnArray[$i]['imageUrl']    = $thumbAttr["url"];

                        $i++;

                    }
                }

            }else{
                $error = "An error occured - Please launch command `php app/console ctc:webstagram --id='[YOUR_INSTAGRAM_ID]'` before to display content";

            }
        }else{
            $error = "An error occured - Please launch command `php app/console ctc:webstagram --id='[YOUR_INSTAGRAM_ID]'` before to display content";
        }



        return $this->render(
            $template,
            array(
                'feed'          => $returnArray,
                'name'          => $name,
                'description'   => $description,
                'error'         => $error
            )
        );

    }

}
