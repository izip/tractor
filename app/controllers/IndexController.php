<?php
use Phalcon\Mvc\View,
    Phalcon\Mvc\Model\Query;


class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->view->setTemplateAfter('main');


        Phalcon\Tag::setTitle('MashinoSmena.ru');
        parent::initialize();
    }

    public function indexAction()
    {
        if ($this->request->hasPost('up')) {
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        }
        if ($this->request->hasPost('cat_id') && $this->request->isAjax()) {
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

            $cat_id = $this->request->getPost('cat_id');
        }

        if ($this->modelsCache->exists('filter-' . $this->session->get('user_id'))) {
            $filter = $this->modelsCache->get('filter-' . $this->session->get('user_id'));
            //$this->elements->var_print($filter);


            $aOff = $aDann = $aUser = $aTabs = array();
            // Следующая строка будет добавляться, видимо, всегда -- мы всегда будем искать в конкретной категории
            $aOff[] = "o.category_id = {$filter['cat_id']}";

            $rq_type = 0;
            $rq_type += (isset($filter['price-from']) && is_numeric($filter['price-from']) && $filter['price-from'] >= 0) ? 1 : 0;
            $rq_type += (isset($filter['price-to']) && is_numeric($filter['price-to']) && $filter['price-to'] >= 0) ? 2 : 0;
            $price_id = 5;
            switch ($rq_type) {
                case 0: // Ничего не добавляет, пусто
                    break;
                case 1:
                    $aDann[] = "do.field_type_id = $price_id and do.dann >= {$filter['price-from']}";
                    break;
                case 2:
                    $aDann[] = "do.field_type_id = $price_id and do.dann <= {$filter['price-to']}";
                    break;
                case 3:
                    $aDann[] = "do.field_type_id = $price_id and do.dann between {$filter['price-from']} and {$filter['price-to']}";
                    break;
            }
            // 4 как код города мы здесь задаём вручную -- потом это можно будет поменять, если нужно
            if ((isset($filter['city'])) && strlen(trim($filter['city'])) > 0)
                $aDann[] = "do.field_type_id = 4 and do.dann like '%{$filter['city']}%'";

            // ICH -- все обработки полей вставляем здесь
            $aFromTo = array();
            $rRes = $rRes1 = array();


            foreach ($filter as $key => $val) {
                if (preg_match('/^(to|from)fiel-(\d+)$/', $key, $rRes))
                    $aFromTo[$rRes[2]][$rRes[1]] = $val;
                elseif ($key == $val) {
                    if (preg_match('/^fiel-(\d+)$/', $key, $rRes1))
                        $aDann[] = "do.field_type_id = {$rRes1[1]} and do.dann = 'y'";
                    else switch ($key) {
                        case 'tel':
                            $aUser[] = 'u.phone is not null';
                            break;
                        case 'image':
                            $aOff[] = 'o.image is not null';
                            break;
                        case 'trof':
                            break;
                        default:
                            // Какая-то непредусмотренная фигня
                            break;
                    }
                    // $rRes1[1] содержит интересующее нас число

                }
            }
            // $this->elements->var_print($aFromTo);

            foreach ($aFromTo as $key => $val) {
                $rq_type = 0;
                $rq_type += (isset($filter["fromfiel-$key"]) && is_numeric($filter["fromfiel-$key"]) && $filter["fromfiel-$key"] >= 0) ? 1 : 0;
                $rq_type += (isset($filter["tofiel-$key"]) && is_numeric($filter["tofiel-$key"]) && $filter["tofiel-$key"] >= 0) ? 2 : 0;

                switch ($rq_type) {
                    case 0: // Ничего не добавляет, пусто
                        break;

                    case 1:
                        $aDann[] = "do.field_type_id = $key and DannOffers.dann >= " . $filter["fromfiel-$key"];
                        break;

                    case 2:
                        $aDann[] = "do.field_type_id = $key and do.dann <= " . $filter["tofiel-$key"];
                        break;

                    case 3:
                        $aDann[] = "do.field_type_id = $key and do.dann between " . $filter["fromfiel-$key"] . ' and ' . $filter["tofiel-$key"];
                        break;
                } // switch
            } // foreach
            // Тут начинается сборка запроса на основании подготовленных массивов


            $nDann = count($aDann);
            $hasDann = ($nDann > 0);
            $hasUser = (count($aUser) > 0);
            $aTabs[] = 'Offers o';
            if ($hasDann) {
                $aTabs[] = 'DannOffers do';
                $aOff[] = 'o.id = do.offers_id';
                $rqDann = $this->ic->fsis($aDann, NULL, '(%s)', "\n  or ", "\n and (%s)");
            }
            if ($hasUser) {
                $aTabs[] = 'User u';
                $aOff[] = 'o.user_id = u.id';
            }
            $rqFrom = implode(', ', $aTabs);
            //$rqDann = implode(' or ', $aDann);
            $rqSql = "select o.id from $rqFrom\n where ";


            $rqSql .= implode("\n and ", $aOff);
            if ($hasUser)
                $rqSql .= "\n and " . implode(' and ', $aUser);
            //$rqSql .= "\n and ($rqDann)\n";
            if ($hasDann)
                $rqSql .= $rqDann;
            // Здесь мы пройдёмся по юзерсу
            if ($hasDann)
                $rqSql .= "\ngroup by o.id\nhaving count(do.id) = $nDann";
            // limit можно добавить здесь, когда придёт время
//        $this->elements->var_print(nl2br($rqSql));
            //  $this->elements->var_print($rqSql);


            ////// Начало SQL запроса


            $query = $this->modelsManager->createQuery($rqSql)
                //   ->cache(array('key'=>'countries', 'lifetime' => 86400))
                ->execute()
                ->toArray();
            $a0 = array();
            foreach ($query as $val)
                $a0[] = $val['id'];
            $inClause = count($a0) > 0 ? 'id in (' . implode(', ', $a0) . ')' : '';


//////  Конец SQL запроса дальше выборка.


            foreach (Offers::find(array("{$inClause}", 'order' => 'creation_date DESC', "limit" => 25)) as $offers) {

                if (isset($offers->image)) {
                    $im = 1;
                } else {
                    $im = 0;
                }

                $off[$offers->id]['name'] = array($offers->name, $im, $offers->status, $offers->user->phone, $offers->categories->name);
                foreach ($offers->dannoffers as $dan) {

                    $off[$offers->id][$dan->fieldtype->id] = $dan->dann;

                }
            }

            if (strlen($inClause) == 0) {
                $this->flash->error("Ничего не найдено фильтр сброшен");

            }
            $this->modelsCache->delete('filter-' . $this->session->get('user_id'));


        } else {
            $zap = '';
            if (isset($cat_id) && is_numeric($cat_id)) {
                $zap = "id = {$cat_id} or id_sub = {$cat_id}";
                $c_cat = 1;

                foreach (Categories::find(array("{$zap}")) as $csv) {

                    $c_cat = $c_cat + $csv->offers->count();

                }
                if ($c_cat == 1) {
                    $this->view->disable();
                    echo 1;
                    die();
                }
            }

            foreach (Categories::find(array("{$zap}")) as $cat) {

                foreach ($cat->getoffers(array('order' => 'creation_date DESC', "limit" => 25)) as $offers) {

                    if (isset($offers->image)) {
                        $im = 1;
                    } else {
                        $im = 0;
                    }

                    // Выдавать в таком виде результат
                    $off[$offers->id]['name'] = array($offers->name, $im, $offers->status, $offers->user->phone, $offers->categories->name);

                    foreach ($offers->dannoffers as $dan) {


                        $off[$offers->id][$dan->fieldtype->id] = $dan->dann;


                    }
                }
            }
        }


        $this->view->setVars(array(

            "off" => $off = (isset($off)) ? $off : false
        ));

    }


    public function offerAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        if (isset($_POST['offer'])) {
            $offer_id = $this->request->getPost('offer');
            $offer = Offers::findFirst($offer_id);
            $date = new DateTime($offer->creation_date);
            $date = $date->format('Y-m-d H:i');

            if (isset($offer->image)) {
                $image = unserialize($offer->image);
            } else {

                $image = '';
            }
            foreach ($offer->dannoffers as $dann) {

                if ($dann->field_type_id == 14) {
                    $operator = $dann->dann;
                } elseif ($dann->field_type_id == 7) {
                    $gsm = $dann->dann;
                } elseif ($dann->field_type_id == 6) {
                    $dost = $dann->dann;
                } elseif ($dann->field_type_id == 15) {
                    $rad_dost = $dann->dann . " " . $dann->fieldtype->pref;;
                } elseif ($dann->field_type_id == 16) {
                    $stat = $dann->dann;
                } elseif ($dann->field_type_id == 5) {
                    $price = $dann->dann;
                } elseif ($dann->field_type_id == 17) {
                    $spec = $dann->dann;
                }
                foreach ($offer->categories->fieldtype as $field) {
                    if ($field->id == $dann->field_type_id) {

                        $cat_dann[$field->name] = $dann->dann . " " . $field->pref;
                    }

                }
                if (count(Categories::find(array("id = {$offer->categories->id_sub}"))) > 0) {
                    foreach (Categories::findFirst(array("id = {$offer->categories->id_sub}"))->fieldtype as $fiel) {
                        if ($fiel->id == $dann->field_type_id) {

                            $cat_dann[$fiel->name] = $dann->dann . " " . $fiel->pref;
                        }

                    }
                }


            }

            foreach ($offer->comments as $comment) {

                $comm[$comment->id] = array(
                    'reciever' => $comment->user->first_name,
                    'text' => $comment->text,
                    'date' => $comment->creation_date
                );

            }

            $this->view->setVars(array(
                'name' => $nm = (isset($offer->user->first_name)) ? $offer->user->first_name : false,
                'user_id' => $id_u = (isset($offer->user->id)) ? $offer->user->id : false,
                'offer_id' => $id = (isset($offer->id)) ? $offer->id : false,
                'offer_name' => $of_name = (isset($offer->name)) ? $offer->name : false,
                'offer_date' => $dat = (isset($date)) ? $date : false,
                'offer_text' => $text = (isset($offer->text)) ? $offer->text : false,
                'offer_image' => $image,
                'oper' => $oper = (isset($operator)) ? $operator : false,
                'gsm' => $gsm = (isset($gsm)) ? $gsm : false,
                'dost' => $dost = (isset($dost)) ? $dost : false,
                'radius_d' => $rad_dost = (isset($rad_dost)) ? $rad_dost : false,
                'status' => $stat = (isset($stat)) ? $stat : false,
                'price' => $price = (isset($price)) ? $price : false,
                'cat_dann' => $cat_dann = (isset($cat_dann)) ? $cat_dann : false,
                'spec' => $spec = (isset($spec)) ? $spec : false,
                'comments' => $comm = (isset($comm)) ? $comm : false

            ));


        }


    }


    public function contactAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->session->has('auth') && $this->request->hasPost('offer_id')) {

            $offer = Offers::findFirst($this->request->getPost('offer_id'));
            $user = $offer->user;
            $this->view->setVars(array(
                'user_id' => $id = $user->id,
                'first_name' => $name = (isset($user->first_name)) ? $user->first_name : false,
                'organization' => $org = (isset($user->organization)) ? $user->organization : false,
                'profession' => $profession = (isset($user->profession)) ? $user->profession : false,
                'phone' => $phone = (isset($user->phone)) ? $user->phone : false,
                'email' => $email = (isset($user->email)) ? $user->email : false,
                'country' => $country = (isset($user->country)) ? $user->country : false,
                'adress' => $adress = (isset($user->adress)) ? $user->adress : false,


            ));

        }

        if ($this->session->has('auth') && $this->request->hasPost('order_id')) {

            $prop = Proposal::findFirst($this->request->getPost('order_id'));
            $user = $prop->user;
            $this->view->setVars(array(
                'user_id' => $id = $user->id,
                'first_name' => $name = (isset($user->first_name)) ? $user->first_name : false,
                'organization' => $org = (isset($user->organization)) ? $user->organization : false,
                'profession' => $profession = (isset($user->profession)) ? $user->profession : false,
                'phone' => $phone = (isset($user->phone)) ? $user->phone : false,
                'email' => $email = (isset($user->email)) ? $user->email : false,
                'country' => $country = (isset($user->country)) ? $user->country : false,
                'adress' => $adress = (isset($user->adress)) ? $user->adress : false,


            ));

        }
        if ($this->session->has('auth') && $this->request->hasPost('di_id')) {

            $dial = Dialogs::findFirst($this->request->getPost('di_id'));
            foreach ($dial->user as $users) {
                if ($users->id != $this->session->get('user_id')) {
                    $user = User::findFirst($users->id);
                }

            }

            $this->view->setVars(array(
                'user_id' => $id = $user->id,
                'first_name' => $name = (isset($user->first_name)) ? $user->first_name : false,
                'organization' => $org = (isset($user->organization)) ? $user->organization : false,
                'profession' => $profession = (isset($user->profession)) ? $user->profession : false,
                'phone' => $phone = (isset($user->phone)) ? $user->phone : false,
                'email' => $email = (isset($user->email)) ? $user->email : false,
                'country' => $country = (isset($user->country)) ? $user->country : false,
                'adress' => $adress = (isset($user->adress)) ? $user->adress : false,


            ));

        }

        if ($this->session->has('auth') && $this->request->hasPost('user_id')) {


            $user = User::findFirst($this->request->getPost('user_id'));


            $this->view->setVars(array(
                'user_id' => $id = $user->id,
                'first_name' => $name = (isset($user->first_name)) ? $user->first_name : false,
                'organization' => $org = (isset($user->organization)) ? $user->organization : false,
                'profession' => $profession = (isset($user->profession)) ? $user->profession : false,
                'phone' => $phone = (isset($user->phone)) ? $user->phone : false,
                'email' => $email = (isset($user->email)) ? $user->email : false,
                'country' => $country = (isset($user->country)) ? $user->country : false,
                'adress' => $adress = (isset($user->adress)) ? $user->adress : false,


            ));

        }


    }


    public function commentsAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        if ($this->request->hasPost('comm') && $this->request->hasPost('offer') && $this->request->isAjax()) {

            $comments = new Comments();
            $comments->offers_id = $this->request->getPost('offer');
            $comments->reciever_id = $this->session->get('user_id');
            $comments->text = $this->request->getPost('comm');
            $comments->creation_date = date("Y-m-d-H-i-s");
            $comments->save();


            $offer = Offers::findFirst($this->request->getPost('offer'));

            foreach ($offer->comments as $comm) {

                $com[$comm->id] = array(
                    $comm->user->first_name,
                    $comm->text,
                    $comm->creation_date
                );

            }
            $this->view->setVars(array(
                'comm' => $com

            ));


        }


    }

    public function autcAction()
    {
        $this->view->disable();
        foreach (Location::find(array("cache" => array("lifetime" => 3600, "key" => "autc-key"))) as $loc) {

            $city[] = $loc->city;

        }

        echo json_encode($city);
    }

}
