<?php

/**
 * Wszelkie prawa zastrzeżone 2018 Norbert Gil oraz Daniel Dymiński 
 */

class FormCreator { 

    private $formSets;
    private $formClasses;
    private $formObjects;
    public $formErrors;

    /**
     * Konstruktor klasy 
     * 
     * @param $formName - Nazwa formualrza
     * @param $formConfig - Tablica konfiguracyjna do formularza
     */
    public function __construct ( $formName, $formConfig )
    {
        if(!$formName){
            throw new ExceptionForms('Formularz podczas procesu tworzeniu powienien posiadać unikatową nazwę', 1);
        }
        $this->setForm( $formName, $formConfig );
    }

    /**
     * Metoda konfigurująca ustawienia nowego obiektu formularza
     * 
     * @param $formName - Nazwa formualrza
     * @param $formConfig - Tablica konfiguracyjna do formularza
     */
    private function setForm( $formName, $formConfig )
    {
        $this->formSets = array (
            'name' => str_replace(" ", "-", $formName),
			'title' => ($formConfig['title'] ? $formConfig['title'] : $formName),
			'method' => ($formConfig['method'] ? $formConfig['method'] : 'post'),
			'action' => ($formConfig['action'] ? $formConfig['action'] : ''),
            'enctype' => ($formConfig['enctype'] ? $formConfig['enctype'] : ''),
            'class' => ($formConfig['class'] ? $formConfig['class'] : ''),
			'specialKey' => ($formConfig['specialKey'] ? $formConfig['specialKey'] : $this->generateKey())
        );
    }

    /**
     * Metoda generująca losowy klucz
     * 
     * @return Wygenerowany klucz 
     */
    protected function generateKey()
    {
        $value = md5(uniqid(rand(), true));
        $value = hash_hmac('ripemd160', $value, 'begining');
        return $value;
    }

    /**
     * Metoda dodająca nową klasę w formularzu 
     * 
     * @param $className - Nazwa klasy
     * @param $classParams - Tablica konfiguracyjna do klasy
     */
    public function addClass( $className, $classParams )
    {
        if(!$className){
            throw new ExceptionForms('Nowa klasa w formularzu musi posiadać unikatową nazwę', 2);
        }
        $this->formClasses[str_replace(" ", "-", $className)] = array (
            'title'	 		 => $classParams['title'],
            'description'	 => $classParams['description']
        );
    }

    /**
     * Metoda dodająca nowy obiekt w formularzu 
     * 
     * @param $className - Nazwa obiektu
     * @param $parentClass - Rodzic obiektu (nazwa klasy w formularzu)
     * @param $objectParams - Tablica konfiguracyjna do obiektu
     */
    public function addObject( $objectName, $parentClass, $objectParams )
    {
        if(!$objectName){
            throw new ExceptionForms('Nowy obiekt w formularzu musi posiadać unikatową nazwę', 3);
        }
        if(!$parentClass){
            throw new ExceptionForms('Nowy obiekt w formularzu musi posiadać nazwe klasy do ktorej należy', 4);
        }
        if($objectParams['type'] == 'submit'){
            throw new ExceptionForms('Do tworzenia obiektu przycisku służy funkcja addButton( $nazwa_przycisku , $nazwa_przynależnej_klasy , $parametry_przycisku, $typ_przycisku = "submit" )', 5);
        }
        $this->formObjects[str_replace(" ", "-", $objectName)] = array (
            'name'           => $objectName,
            'title'          => ($objectParams['title'] ? $objectParams['title'] : ($objectParams['title'] == false ? '' : $objectName)),
            'class'          => $parentClass,
            'css_class'      => $objectParams['class'],
            'type'	 	     => $objectParams['type'],
            'section'	  	 => $objectParams['section'],
            'value'	 		 => $objectParams['value'],
            'comment'	 	 => $objectParams['comment'],
            'placeholder'	 => $objectParams['placeholder'],
            'options'        => $objectParams['options'],
            'content'        => $objectParams['content'],
            'multiple'       => $objectParams['multiple'],
            'autocomplete'   => $objectParams['autocomplete'],
            'accept'         => $objectParams['accept'],
            'list'           => $objectParams['list']
        );
    }

    /**
     * Metoda dodająca nowy przycisk w formularzu 
     * 
     * @param $buttonName - Nazwa przycisku
     * @param $parentClass - Rodzic przycisku (nazwa klasy w formularzu)
     * @param $buttonParams - Tablica konfiguracyjna do przycisku
     * @param $buttonType - Typ nowego przycisku (domyślnie - submit)
     */
    public function addButton( $buttonName, $parentClass, $buttonParams, $buttonType = 'submit' )
    {
        if(!$buttonName){
            throw new ExceptionForms('Nowy przycisk w formularzu musi posiadać unikatową nazwę', 3);
        }
        if(!$parentClass){
            throw new ExceptionForms('Nowy przycisk w formularzu musi posiadać nazwe klasy do ktorej należy', 4);
        }
        $this->formObjects[str_replace(" ", "-", $buttonName)] = array(
            'name'           => $buttonName,
            'title'          => ($buttonParams['title'] ? $buttonParams['title'] : ''),
            'value'          => ($buttonParams['value'] ? $buttonParams['value'] : $buttonName),
            'class'          => $parentClass,
            'css_class'      => $buttonParams['class'],
            'type'	 	     => $buttonType,
            'comment'	 	 => $buttonParams['comment']
        );
    }

    /**
     * Metoda dodająca nowe komunikat w formularzu
     * 
     * @param $className - Nazwa klasy rodzicielskiej
     * @param $error - Komunikat
     */
    public function addError( $className, $error )
    {
        $this->formErrors[$className] = $error;
    }

    /**
     * Metoda sprawdzająca czy istnieją jakieś komunikaty w tablicy
     */
    public function checkErrors()
    {
        if($this->formErrors) return true;
        else return false;
    }

    /**
     * Metoda tworząca nowy formularz
     */
    public function displayForm()
    {
        echo '<form method="'.$this->formSets['method'].'" action="'.$this->formSets['action'].'" name="'.$this->formSets['name'].'" id="form-'.$this->formSets['name'].'" enctype="'.$this->formSets['enctype'].'" class="'.$this->formSets['class'].'">';
        foreach ($this->formClasses as $keyClass => $class){
            echo '<section class="form-section form-section-'.$keyClass.'">';
            if( $class['title'] ) echo '<h5>'.$class['title'].'</h2>';
            if($this->formErrors[$keyClass]){
                echo '<section class="section-errors">';
                foreach ($this->formErrors as $key => $value) {
                    if($key == $keyClass){
                        echo '<div class="error-message">';
                        echo $value;
                        echo '</div>';
                    }
                }
                echo '</section>';
            }
            foreach ($this->formObjects as $keyObj => $object){
                if($object['class'] == $keyClass){
                    echo '<div class="form-object form-object-'.$object['name'].'">';
                    if($object['title'] != '') echo '<div class="form-object-title">'.$object['title'].'</div>';
                    if($object['type'] == 'select'){
                        $select = "<select";
                        $select .= " name='" . $keyObj . ($object['multiple'] ? "[]" : '') . "'";
                        $select .= " class='" . $object['css_class'] . "'";
                        $select .= ($object['multiple'] ? "multiple" : '');
                        $select .= '>';
                        foreach($object['options'] as $value_option){
                            $select .= '<option value="' . $value_option['name'] . '" ' . ($_POST[$keyObj] == $value_option['name'] ? 'selected' : '') . '>' . $value_option['title'] . '</option>';
                        }
                        $select .= '</select>';
                        echo $select;
                    } elseif($object['type'] == 'textarea'){
                        echo '<textarea name="'.$keyObj.'">'.$object['value'].'</textarea>';
                    } elseif($object['type'] == 'html'){
                        echo $object['content'];
                    } elseif($object['type'] == 'radio'){
                        $input = '';
                        foreach ($object['list'] as $inputElem) {
                            $input .= "<div class='form-object-" . $object['name'] . "-radio" . ($inputElem['value'] == $object['value'] ? ' active' : '') . "'>";
                            $input .= "<input";
                            $input .= " name='" . $keyObj . "[]'";
                            if($object['type']) $input .= " type='" . $object['type'] . "'";
                            if($object['value'] || $_POST[$keyObj]) $input .= " value='" . $inputElem['value'] . "'";
                            if($object['placeholder']) $input .= " placeholder='" . $object['placeholder'] . "'";
                            if($object['css_class']) $input .= " class='" . $object['css_class'] . "'";
                            if($object['style']) $input .= " style='" . $object['style'] . "'";
                            $input .= " autocomplete='" . (!$object['autocomplete'] ? 'off' : 'on') . "'";
                            if($inputElem['value'] == $object['value']) $input .= ' checked';
                            $input .= '>';
                            if($inputElem['label']) $input .= '<label>' . $inputElem['label'] . '</label>';
                            $input .= '</div>';
                        }
                        echo $input;
                    } else {
                        $input = "<input";
                        $input .= " name='" . $keyObj . "'";
                        if($object['type']) $input .= " type='" . $object['type'] . "'";
                        if($object['value'] || $_POST[$keyObj]) $input .= " value='" . ($_POST[$keyObj] ? $_POST[$keyObj] : $object['value']) . "'";
                        if($object['placeholder']) $input .= " placeholder='" . $object['placeholder'] . "'";
                        if($object['css_class']) $input .= " class='" . $object['css_class'] . "'";
                        if($object['style']) $input .= " style='" . $object['style'] . "'";
                        if($object['accept']) $input .= " accept='" . $object['accept'] . "'";
                        $input .= " autocomplete='" . (!$object['autocomplete'] ? 'off' : 'on') . "'";
                        $input .= '>';
                        echo $input;
                    }
                    if($this->formErrors[$keyObj]){
                        echo '<section class="object-errors">';
                        foreach ($this->formErrors as $key => $value) {
                            if($key == $keyObj){
                                echo '<div class="error-message">';
                                echo $value;
                                echo '</div>';
                            }
                        }
                        echo '</section>';
                    }
                    if($object['comment'] != '') echo '<div class="form-object-comment">'.$object['comment'].'</div>';
                    echo '</div>';
                }
            }
            echo '</section>';
        }
        echo '</form>';
    }
}

?>