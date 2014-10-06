<?php

use Phalcon\Mvc\View;
use Phalcon\Image\Adapter\GD as GdAdapter;

class MyoffersController extends ControllerBase
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

        if ($this->session->has('user_id')) {
            $id = $this->session->get('user_id');
            $user = User::findFirst($id);


            foreach ($user->offers as $offers) {
                $image = unserialize($offers->image);
                if (isset($image['image-big-1'])) {
                    $im = 1;
                } else {
                    $im = 0;
                }
                $off[$offers->id]['name'] = array($offers->name, $im, $offers->status, $offers->user->phone ,$offers->categories->name);

                if (isset($offers->id)) {
                    foreach ($offers->dannoffers as $dan) {


                        $off[$offers->id][$dan->fieldtype->id] = $dan->dann;


                    }
                }
            }
        }
        //  $this->elements->var_print($off);
        $this->view->setVars(array(

            "cn" => count($user->offers),
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
                    $rad_dost = $dann->dann;
                } elseif ($dann->field_type_id == 16) {
                    $stat = $dann->dann;
                } elseif ($dann->field_type_id == 5) {
                    $price = $dann->dann;
                } elseif ($dann->field_type_id == 17) {
                    $spec = $dann->dann;
                }
                foreach ($offer->categories->fieldtype as $field) {
                    if ($field->id == $dann->field_type_id) {

                        $cat_dann[$field->name] = $dann->dann;
                    }

                }
                if (count(Categories::find(array("id = {$offer->categories->id_sub}"))) > 0) {
                    foreach (Categories::findFirst(array("id = {$offer->categories->id_sub}"))->fieldtype as $fiel) {
                        if ($fiel->id == $dann->field_type_id) {

                            $cat_dann[$fiel->name] = $dann->dann;
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

    public function subcatAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->request->hasPost('cat_id') && $this->request->isAjax()) {

            $cat_id = $this->request->getPost('cat_id');
            foreach (Categories::find(array("id_sub = {$cat_id}")) as $categ) {
                $sub_cat[$categ->id] = $categ->name;

            }


            $this->view->setVars(array(
                'sub_cat' => $sub_cat = (isset($sub_cat)) ? $sub_cat : false

            ));
        }
    }


    public function catfAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->request->hasPost('cat_id') && $this->request->isAjax()) {

            $cat_id = $this->request->getPost('cat_id');
            $categ = Categories::findFirst($cat_id);
            foreach ($categ->fieldtype as $cat_fiel) {
                $cat[$cat_fiel->id] = array($cat_fiel->name, $cat_fiel->pref, $cat_fiel->dtype);
            }


            $this->view->setVars(array(
                'cat' => $cat = (isset($cat)) ? $cat : false,
                'c' => $c = ($this->request->hasPost('c')) ? $this->request->getPost('c') : false
            ));
        }
    }

    public function addofferAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->request->isAjax()) {

            $cat_id = Categories::findFirst()->id;

            foreach (FieldType::find() as $field) {

                $fil[$field->id] = $field->name;

            }

            foreach (Categories::find(array("id_sub =0")) as $categ) {
                $category[$categ->id] = $categ->name;

            }


            foreach (Categories::find(array("id_sub = {$cat_id}")) as $categ) {
                $sub_cat[$categ->id] = $categ->name;

            }

            $cat = Categories::findFirst($cat_id);
            foreach ($cat->fieldtype as $cat_field) {
                $cat_f[$cat_field->id] = array($cat_field->name, $cat_field->pref, $cat_field->dtype);
            }

            //$this->elements->var_print($cat);

            $this->view->setVars(array(
                'field' => $fil,
                'cat_field' => $cat_f = (isset($cat_f)) ? $cat_f : false,
                'sub_cat' => $sub_cat = (isset($sub_cat)) ? $sub_cat : false,
                'cat' => $category = (isset($category)) ? $category : false
            ));

        }


    }

    public function redofferAction()
    {

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        if ($this->request->hasPost('offer_id')) {


            foreach (FieldType::find() as $field) {

                $fil[$field->id] = $field->name;

            }
            $offer = Offers::findFirst($this->request->getPost('offer_id'));

            foreach ($offer->dannoffers as $dan) {

                $dan_fil[$dan->fieldtype->id] = $dan->dann;

            }


            $cat = $offer->categories;
            $cat_id = $cat->id;
            foreach (Categories::find(array("id_sub =0")) as $categ) {
                $category[$categ->id] = $categ->name;

            }
            // Получение родительской категории
            if (count(Categories::find(array("id_sub = {$cat->id}"))) > 0) {
                foreach (Categories::find(array("id_sub = {$cat->id}")) as $categ) {

                    $sub_cat[$categ->id] = $categ->name;

                }
            } else {
                foreach (Categories::find(array("id = {$cat->id_sub}")) as $categ) {

                    $par_cat = $categ->id;

                    foreach (Categories::find(array("id_sub = {$categ->id}")) as $cate) {

                        $sub_cat[$cate->id] = $cate->name;

                    }
                }

            }

            if (count(Categories::find(array("id = {$cat->id_sub}"))) > 0) {
                foreach (Categories::findFirst(array("id = {$cat->id_sub}"))->fieldtype as $cat_field) {
                    $cat_fd[$cat_field->id] = array($cat_field->name, $cat_field->pref, $cat_field->dtype);
                }
            }
            foreach ($cat->fieldtype as $cat_field) {
                $cat_f[$cat_field->id] = array($cat_field->name, $cat_field->pref, $cat_field->dtype);
            }


            //  $this->elements->var_print($dan_fil);

            if (!isset($sub_cat)) {

                $par_cat = $cat_id;


            }

            $this->view->setVars(array(
                'field' => $fil,
                'cat_field' => $cat_f = (isset($cat_f)) ? $cat_f : false,
                'cat_fieldf' => $cat_fd = (isset($cat_fd)) ? $cat_fd : false,
                'offer_name' => $offer_name = (isset($offer->name)) ? $offer->name : false,
                'offer_text' => $off = (isset($offer->text)) ? $offer->text : false,
                'offer_id' => $off = (isset($offer->id)) ? $offer->id : false,
                'dan_fil' => $dan_fil = (isset($dan_fil)) ? $dan_fil : false,
                'par_cat' => $par_cat = (isset($par_cat)) ? $par_cat : false,
                'cat_id' => $cat_id = (isset($cat_id)) ? $cat_id : false,
                'cat' => $category = (isset($category)) ? $category : false,
                'sub_cat' => $sub_cat = (isset($sub_cat)) ? $sub_cat : false

            ));

        }


    }

    public function addofferformAction()
    {

        $this->view->disable();

        function valid_form_offer()
        {

            $sub_mess = '';


            if (!isset($_POST['model']) || strlen($_POST['model']) < 3) {

                $sub_mess['model'] = 'Не корректно заполнено поле Модель:';

            }


            if (!isset($_POST['cat_id'])) {

                $sub_mess['cat_id'] = 'Не корректно заполнено поле Класс:';

            }
            if (!isset($_POST['city']) || strlen($_POST['city']) < 3) {

                $sub_mess['city'] = 'Не корректно заполнено поле Город:';

            }
            if (!isset($_POST['price']) || strlen($_POST['price']) < 2) {

                $sub_mess['price'] = 'Не корректно заполнено поле Цена:';

            }
            if (!isset($_POST['text_offer']) || strlen($_POST['text_offer']) < 5) {

                $sub_mess['text_offer'] = 'Не корректно заполнено поле Характеристики техники: ';

            }


            if (is_array($sub_mess)) {
                echo json_encode($sub_mess);
                return false;
            } else {

                return true;

            }
        }


        if (valid_form_offer()) {

            //// Обработчик формы предложения
            $user_id = $this->session->get('user_id');
            $cat_id = $this->session->get('cat_id');
            $el = new Elements();
            $el->dir_valid($user_id);
            if ($this->request->hasPost('offer_id')) {

                $offer = Offers::findFirst($this->request->getPost('offer_id'));
            } else {

                $offer = new Offers();
            }

            $offer->name = $this->request->getPost('model');
            $offer->user_id = $user_id;
            if ($this->request->hasPost('sub_cat_id')) {
                $offer->category_id = $this->request->getPost('sub_cat_id');
            } else {
                if ($this->request->hasPost('cat_id')) {
                    $offer->category_id = $this->request->getPost('cat_id');
                }

            }
            $offer->creation_date = date("Y-m-d-H-i-s");
            $offer->text = $this->request->getPost('text_offer');
            if ($this->request->hasPost('public') && $this->request->getPost('public') == 'y') {
                $offer->status = 1;
            }
            $offer->save();
            if ($offer->save() == false) {

                foreach ($offer->getMessages() as $message) {

                }
            } else {

            }

            // Поля
            if ($this->request->hasPost('offer_id')) {

                foreach ($offer->dannoffers as $dann) {
                    $dann->delete();
                }
            }

            if ($this->request->hasPost('city')) {

                $dann = new DannOffers();
                $dann->dann = $this->request->getPost('city');
                $dann->field_type_id = 4;
                $dann->offers_id = $offer->id;
                $dann->active = 1;
                $dann->save();

            }

            if ($this->request->hasPost('price')) {

                $dann = new DannOffers();
                $dann->dann = $this->request->getPost('price');
                $dann->field_type_id = 5;
                $dann->offers_id = $offer->id;
                $dann->active = 1;
                $dann->save();

            }

            if ($this->request->hasPost('oper')) {

                $dann = new DannOffers();
                $dann->dann = $this->request->getPost('oper');
                $dann->field_type_id = 14;
                $dann->offers_id = $offer->id;
                $dann->active = 1;
                $dann->save();

            }

            if ($this->request->hasPost('gsm-act')) {

                $dann = new DannOffers();
                $dann->dann = $this->request->getPost('gsm-act');
                $dann->field_type_id = 7;
                $dann->offers_id = $offer->id;
                $dann->active = 1;
                $dann->save();


            }

            if ($this->request->hasPost('rad-dost')) {

                $dann = new DannOffers();
                $dann->dann = $this->request->getPost('rad-dost');
                $dann->field_type_id = 15;
                $dann->offers_id = $offer->id;
                $dann->active = 1;
                $dann->save();


            }


            if ($this->request->hasPost('dost-act')) {

                $dann = new DannOffers();
                $dann->dann = $this->request->getPost('dost-act');
                $dann->field_type_id = 6;
                $dann->offers_id = $offer->id;
                $dann->active = 1;
                $dann->save();


            }


            foreach ($_POST as $key => $fil) {
                if (stripos($key, 'fil_cat') !== false) {

                    $dann = new DannOffers();
                    $dann->dann = $this->request->getPost($key);
                    $dann->field_type_id = intval(str_replace('fil_cat-', '', $key));
                    $dann->offers_id = $offer->id;
                    $dann->active = 1;
                    $dann->save();


                }

            }


            /// Фото
            if ($this->request->hasFiles() == true) {
                $i = 0;
                // Выводим имя и размер файла
                foreach ($this->request->getUploadedFiles() as $file) {
                    $i++;


                    // Перемещаем в приложение
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/upload/users/user-' . $user_id . '/offers/offer-' . $offer->id)) {

                    } else {
                        mkdir($_SERVER['DOCUMENT_ROOT'] . '/public/upload/users/user-' . $user_id . '/offers/offer-' . $offer->id);
                    }

                    $file->moveTo('upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/' . $file->getName());

                    $gd = new GdAdapter('upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/' . $file->getName());
                    $gd->resize(600, 430)
                        ->save('upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/image-big-' . $i . '.jpg');
                    $gd->resize(280, 201)
                        ->save('upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/image-medium-' . $i . '.jpg');
                    $gd->resize(120, 86)
                        ->save('upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/image-small-' . $i . '.jpg');

                    unlink('upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/' . $file->getName());
                    $image['image-big-' . $i] = 'upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/image-big-' . $i . '.jpg';
                    $image['image-medium-' . $i] = 'upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/image-medium-' . $i . '.jpg';
                    $image['image-small-' . $i] = 'upload/users/user-' . $user_id . '/offers/offer-' . $offer->id . '/image-small-' . $i . '.jpg';
                }


                $offer->image = serialize($image);
                $offer->save();
            }

            echo json_encode(array('success' => "Предложение " . $offer->name . " добавлено", 'offer_id' => $offer->id));

            ////Конец Обработчика формы предложения

        }
    }


    public function delofferAction()
    {
        $this->view->disable();
        $user_id = $this->session->get('user_id');

        if ($this->request->isAjax()) {
            $offer = Offers::findFirst($this->request->getPost('offer_id'));
            foreach ($offer->dannoffers as $dann) {

                $dann->delete();

            }
            foreach ($offer->comments as $comment) {

                $comment->delete();

            }


            foreach ($offer->favorites as $fav) {

                foreach (OffersHasFavorites::find(array('favorites_id  = "' . $fav->id . '"')) as $favs) {

                    $favs->delete();

                }


                $fav->delete();

            }

            $offer->delete();


            $el = new Elements();
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/upload/users/user-' . $user_id . '/offers/offer-' . $this->request->getPost('offer_id'))) {

                $el->delete($_SERVER['DOCUMENT_ROOT'] . '/public/upload/users/user-' . $user_id . '/offers/offer-' . $this->request->getPost('offer_id'));
            }


        }

    }


}


?>