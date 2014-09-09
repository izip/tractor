<?php

/*
Сюда я сбрасываю функции из своих библиотек, нужные в проектах
*/

class IC
  {
  const CR = "\r\n";
  const CR2 = "\r\n\r\n";
  const CR3 = "\r\n\r\n\r\n";
  const BR =  '<br>';
  const BR2 =  '<br><br>';

  /**
  Порождение лямбда-функции, экранирующей заданный символ кавычек с помощью бэкслэша
  @param[in] $qChar символ кавычек, который будет экранироваться -- в дальнейшем нужно будет поддерживать строку таких символов
  @return лямбда-функция, осуществляющая экранирование с помощью бэкслэша для переданного символа ( в дальнейшем -- символов )
  */
  static function l_EscQ($qChar)
  {
  if ($qChar == '"')
    $e = '\"';
  else
    $e = $qChar;

  /*
  $f_body = "return str_replace(\"$e\", \"\\\\$e\", \$s);";
  cr($f_body);
  $res = create_function('$s', $f_body);
  */
  $res = create_function("\$s", "return str_replace(\"$e\", \"\\\\$e\", \$s);");
  return $res;
  }


  /**
  Функция выполняет массив замен :-) в массиве строк
  @param[in] $arr исходный одномерный массив строк, в которых ведется замена
  @param[in] $aFrom массив искомых строк
  @param[in] $aTo   массив строк замены
  @param[in] $CSens - чувствительность к регистру, <b>true</b> если чувствительно,
  по умолчанию <b>false</b>
  @return массив с внесенными изменениями

  @remarks
  Должно соблюдаться условие: count($aFrom)==count($aTo)<br>
  Возможно, впоследствии я добавлю новые флаги
  */
  static function ic_AStrReplace($arr, $aFrom, $aTo, $CSens=false)
  {
  /*
  Внутренние переменные
  $opType -- тип операции
  Структура таблицы
  Src -- является ли $arr массивом
  Rpl -- являются ли $aFrom и $aTo массивами
   (они могут быть или не быть таковыми только одновременно)
  Yes -- отлажена ли функция
  $opType  Src  Rpl  Yes
     0      +    +    +
     1      -    +    +
     2      +    -    +
     3      -    -    +

  */
  $opType = (is_array($arr) ? 0 : 1);
  $opType += (is_array($aFrom) ? 0 : 2);

  /*
  cr("opType : $opType");
  cr('$arr:');
  var_dump($arr);
  */

  switch($opType)
   {
   case 0:
   $szArr = count($arr);
   $nSubst = count($aFrom);
   if($nSubst!=count($aTo))
    return $arr;
   for($i = 0; $i < $szArr; $i++)
    if($CSens)
     for($j = 0; $j < $nSubst; $j++)
      $arr[$i] =  str_replace($aFrom[$j], $aTo[$j], $arr[$i]);
    else
     for($j = 0; $j < $nSubst; $j++)
      $arr[$i] =  str_ireplace($aFrom[$j], $aTo[$j], $arr[$i]);
   break;

   case 1:
   $nSubst = count($aFrom);
   if($nSubst!=count($aTo))
    return $arr;
   if($CSens)
    for($j = 0; $j < $nSubst; $j++)
     $arr =  str_replace($aFrom[$j], $aTo[$j], $arr);
   else
    for($j = 0; $j < $nSubst; $j++)
     $arr =  str_ireplace($aFrom[$j], $aTo[$j], $arr);
   break;

   case 2:
   $szArr = count($arr);
   if($CSens)
    for($i = 0; $i < $szArr; $i++)
     $arr[$i] =  str_replace($aFrom, $aTo, $arr[$i]);
   else
    for($i = 0; $i < $szArr; $i++)
     $arr[$i] =  str_ireplace($aFrom, $aTo, $arr[$i]);
   break;

   case 3:
   if($CSens)
    $arr =  str_replace($aFrom, $aTo, $arr);
   else
    $arr =  str_ireplace($aFrom, $aTo, $arr);
   break;
    }
  return $arr;
  }


  static function cr($var='')
  {
  print "$var\n";
  }


  /**
  filter, sprintf, implode, sprintf

  Функция применяет к аргументу цепочку фильтров, распечатывает каждый аргумент по шаблону sprintf и объединяет implode<br>
  Фильтры могут быть переданы как массив имен либо же в строке,
  через разделитель по RE '{[ ,;|\\t]+}'.

  У нас есть серьёзный вопрос: как нам обрабатывать структуры данных, более сложных, чем линейный массив?
  Пока напрашивается 2 возможных ответа:
  1) линеаризовать всё и всё же единообразно склеить
  2) линеаризовать только подмассивы последнего уровня, не имеющие подмассивов
  Второй вариант слишком непривлекателен в реализации и едва ли нужен.
  Мы просто будем предполагать, что скорее всего будет передан одномерный массив, реже -- скаляр.
  Более сложные структуры в этой функции нам пока неинтересны.

  @param[in] $src Исходная строка или массив строк
  @param[in] $filters массив или строка, в которой заданы фильтры. Если после анализа массив фильтров будет пуст -- фильтрация не производится
  @param[in] $spr_1tpl шаблон для распечатки sprintf каждого аргумента. Если шаблон пуст -- подстановка не производится и каждый элемент перед склейкой
    остаётся как есть
  @param[in] $impl_glue клей для $spr_tpl. Если NULL -- массив не склеивается, а возвращается как массив после array_flatten
  @param[in] $spr_atpl шаблон для распечатки sprintf всего результата. Если шаблон пуст -- подстановка не производится и результат
    остаётся как есть
  @return исходный массив, пропущенный через фильтры, распечатанный поэлементно по шаблону и склеенный в строку

  */
  static function fsis($src, $filters = NULL, $spr_1tpl = NULL, $impl_glue = NULL, $spr_atpl = NULL)
  {
  $split_tpl = '{[ ,;|\t]+}';
  if(is_array($filters))
   $aFilters = $filters;
  elseif (is_string($filters))
   $aFilters = preg_split($split_tpl, $filters, -1, PREG_SPLIT_NO_EMPTY);
  else
   $aFilters = array();

  // Прибиваем неработающие фильтры
  foreach($aFilters as $key=>$val)
   if(!function_exists($val))
    unset($aFilters[$key]);

  $hasFilters = (count($aFilters) > 0);
  $has_1tpl = !self::sie($spr_1tpl);
  $has_atpl = !self::sie($spr_atpl);

  // Неплоский массив превращаем в плоский -- надеюсь, побочек не будет
  if(is_array($src))
   $src = self::array_flatten($src);
  else
  // Для единообразия оборачиваем единственную строку в массив
   $src = array($src);

  foreach($src as $key => $val)
   {
   if($hasFilters)
    foreach($aFilters as $fltr)
     // Ставить $val в правой части, по-видимому, нельзя
     $src[$key] = $fltr($src[$key]);
   if($has_1tpl)
    $src[$key] = sprintf($spr_1tpl, $src[$key]);
   }

  if(isset($impl_glue) && !self::sie($impl_glue))
   $src = implode($impl_glue, $src);

  if($has_atpl)
   $src = sprintf($spr_atpl, $src);

  return $src;
  }

  /**
  Проверяет, есть ли в строке что-то кроме пробельных символов
  @param[in] $s тестируемая строка
  */
  static function sie($s)
  {
  return (strlen(trim($s))==0);
  }


  /**
  (c) bluej100 at gmail dot com
  Most of the array_flatten functions don't allow preservation of keys. Mine allows preserve, don't preserve, and preserve only strings (default).
  recursively reduces deep arrays to single-dimensional arrays
  @param[in] $array source array
  @param[in] $preserve_keys: (0=>never, 1=>strings, 2=>always)
  */
  function array_flatten($array, $preserve_keys = 1, &$newArray = Array())
  {
  foreach ($array as $key => $child)
    if (is_array($child))
      $newArray =& self::array_flatten($child, $preserve_keys, $newArray);
    elseif ($preserve_keys + is_string($key) > 1)
      $newArray[$key] = $child;
    else
      $newArray[] = $child;
  return $newArray;
  }

  } // IC

?>