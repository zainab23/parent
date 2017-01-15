<?php
function multi_array_unique($array){
		if (count($array) === 0){
			return array();
		}else{
			$i = 0;
			foreach ($array as $value) {
				$result[$i] = serialize($value);
				$i++;
			}
			$result = array_unique($result);
			$result = array_values($result);
			
			$i = 0;
			foreach ($result as $value) {
				$new_result[$i] = unserialize($value);
				$i++;
			}
			return $new_result;
		}
	}

	function multi_array_sort($array, $column_name){
		if (count($array) === 0){
			return array();
		}else if(count($array) === 1){
			return $array;
		}else{
			$array_column = my_array_column($array, $column_name);
			array_multisort($array_column, SORT_DESC, $array);
			return $array;
		}
	}
	
	
	function my_array_column($array, $column_name){
		
		if ($array){
				$i = 0;
				foreach ($array as $sub_array){
						$new_array[$i] = $sub_array[$column_name];
						$i++;
				}
				return $new_array;
		}
		return false;
		
	}

	function multi_array_extract($array){
		if (count($array) === 0){
			return array();
		}else{
			$i = 0;
			foreach ($array as $sub_array) {
				if (count($sub_array) === 0)
					continue;
				foreach ($sub_array as $value) {
					$result[$i] = $value;
					$i++;
				}
			}
			if (isset($result))
				return $result;
			else
				return array();
		}

	}
  
  function check_cat_translit($category){
    global $BabyFood;
     global $BabyHealth;
     global $NewbornBabies;
     global $BabyGames;
     global $BabyGear;
if($category==="Baby Food"){
            $category=$BabyFood;
          }elseif ($category==="Baby Health") {
            $category=$BabyHealth;
            }elseif ($category==="Newborn Babies") {
            $category=$NewbornBabies;
            }elseif ($category==="Baby Games") {
            $category=$BabyGames;
            }elseif ($category==="Baby Gear") {
            $category=$BabyGear;
            }
            
            return ($category);
}
?>