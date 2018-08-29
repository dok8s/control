<?php

class CtbClass {
    var $file;
    var $fhandle;
    var $index;
    var $sep = "\x0E";
    var $debugMode = 'hidden';//0=不显示，hidden=隐藏，show=显示调试信息

    //按指定模式打开文件并锁定 by cx
    function ctb_fopen($openMode='r', $lockMode=LOCK_SH) {
        if (($openMode == 'r' or $openMode == 'r+') and !file_exists($this->file)) {
            $this->debug("CTB Warning: fopen file not found: $this->file");
        }
        $this->debug("fopen: $this->file, $openMode, $lockMode");
        $this->fhandle = fopen($this->file, $openMode);
        if ($lockMode) {
            $this->debug("flock: $this->file, $lockMode");
            flock($this->fhandle, $lockMode);
        }
    }

    //关闭文件 by cx
    function ctb_fclose() {
        if ($this->fhandle) {
            fclose($this->fhandle);
        }
    }

    //按指定大小以字串返回文件内容，如果没指定则返回全部 by cx
    function ctb_fread($fileSize=0, $doLock=1) {
        if (!file_exists($this->file)) {
            $this->debug("CTB Warning: fread file not found: $this->file");
            return '';
        }
        else {
            $this->debug("fread: $this->file");
            if ($fileSize < 1) {
                $fileSize = filesize($this->file);
            }
            if (!$fileSize) {
                return '';
            }
            if ($doLock) {
                $lockMode == 'LOCK_SH';
            }
            else {
                $lockMode == '';//不需写入的文件读取不锁，如模板调用
            }
            $this->ctb_fopen('r', $lockMode);//或：读写模式打开 'r+'/LOCK_EX
            $returnStr = fread($this->fhandle, $fileSize);
            $this->ctb_fclose();//此处可考虑不关闭：数据处理后再写入，不需再次打开
			return $returnStr;
        }
    }

    //以一维数组返回，文件每行字串作为数组的值，同时获得文件行数
    function read_file() {
        if (!file_exists($this->file)) {
            $this->debug("CTB Warning: file file not found: $this->file");
            $this->linesCnt[$this->file] = 0;
            return array();
        }
        else {
            $this->debug("file: $this->file");
            $returnArr = file($this->file);
            $this->linesCnt[$this->file] = count($returnArr);
        }
        return $returnArr;
    }

    //以二维数组返回文件内容
    function openFile() {
        $fileArr = $this->read_file();
        foreach ($fileArr as $lineStr) {
            $returnArr[] = $this->make_array($lineStr);
        }
        return $returnArr;
    }

    //以输入字串覆盖写入一个文件，如果文件不存在则新建
    function null_write($newStr) {
        $this->ctb_fopen('w', LOCK_EX);
        fputs($this->fhandle, $newStr);
        $this->ctb_fclose();
    }

    //添加输入字串到文件末端，如果文件不存在则新建
    function add_write($newStr) {
        $this->ctb_fopen('a', LOCK_EX);
        fputs($this->fhandle, $newStr);
        $this->ctb_fclose();
    }

    //根据分隔符把一行字串转换为一维数组
    function make_array($lineStr) {
        return explode($this->sep, $lineStr);
    }

    //根据分隔符把为一维数组转换一行字串
    function join_array($array) {
        return join($this->sep, $array);
    }

    //返回数据文件的总行数
    function getlines() {
        if (isset($this->linesCnt[$this->file])) {
            return $this->linesCnt[$this->file];
        }
        return count($this->read_file());
    }

    //将文件的连续行字串构成一维数组的值，$m：初始行，$n：结束行，默认每行 80 字符以下 by cx
    function getFileLines($m, $n, $getLen=80) {
        $this->ctb_fopen('r', LOCK_SH);
        for($i=0; $i<=$n; $i++) {
            $lineStr = fgets($this->fhandle, $getLen);
            if ($i >= $m) {
                $returnArr[] = $lineStr;
            }
        }
        $this->ctb_fclose();
        return $returnArr;
    }

    //返回下一行字串(备用)
    function next_line() {
        $this->index++;
        return $this->get();
    }

    //返回上一行字串(备用)
    function prev_line() {
        $this->index--;
        return $this->get();
    }

    //根据分隔符把当前行字串转换为一维数组
    function get($getLen=1024) {
        $this->ctb_fopen('r', LOCK_SH);
        for($i=0; $i<=$this->index; $i++) {
            $lineStr = fgets($this->fhandle, $getLen);
        }
        $returnArr = $this->make_array($lineStr);
        $this->ctb_fclose();
        return $returnArr;
    }

    //根据分隔符把当前行字串转换为一维数组，数据较大
    function get_big_file() {
        return $this->get(1024 * 5);
    }

    //传入一个数组,合并成一行数据,重写整个文件
    function overwrite($array) {
        $newLineStr = $this->join_array($array);
        $this->null_write($newLineStr);
    }

    //传入一个数组,合并成一行数据,添加到文件末端
    function add_line($array, $check_n=1) {
        $newLineStr = $this->join_array($array);
        if ($check_n == 1) {
            $newLineStr .= "\n";
        }
        $this->add_write($newLineStr);
    }

    //传入一个数组（cx said：最后一个值必须是换行）,合并成一行数据,插入到文件前端
    function insert_line($array) {
        $newFile = $this->join_array($array) . $this->ctb_fread();
        $this->null_write($newFile);
    }

    //更新所有符合条件的数据记录行,适用于每行字节数据较大的情况
    function update($column, $query_string, $update_array) {
        $update_string = $this->join_array($update_array);
        $fileArr = $this->read_file();
        foreach ($fileArr as $lineStr) {
            $lineArr = $this->make_array($lineStr);
            if ($lineArr[$column] != $query_string) {
                $newFile .= trim($lineStr)."\n";
            } else {
                $newFile .= $update_string;
            }
        }
        $this->null_write($newFile);
    }

    //更新所有符合条件的数据记录行,适用于每行字节数据较小的情况
    function update2($column, $query_string, $update_array) {
        $update_string = $this->join_array($update_array);
        $this->ctb_fopen('r', LOCK_SH);
        while ($lineStr = fgets($this->fhandle, 1024)) {
            $lineArr = $this->make_array($lineStr);
            if ($lineArr[$column] != $query_string) {
                $newFile .= trim($lineStr)."\n";
            } else {
                $newFile .= $update_string;
            }
        }
        $this->ctb_fclose();
        $this->null_write($newFile);
    }

    //删除所有符合条件的数据记录行,适用于每行字节数据较大的情况
    function delete($column, $query_string) {
        $fileArr = $this->read_file();
        foreach ($fileArr as $lineStr) {
            $lineArr = $this->make_array($lineStr);
            if ($lineArr[$column] != $query_string) {
                $newFile .= trim($lineStr)."\n";
            }
        }
        $this->null_write($newFile);
    }

    //删除所有符合条件的数据记录行,适用于每行字节数据较小的情况
    function delete2($column, $query_string){
        $this->ctb_fopen('r', LOCK_SH);
        while ($lineStr = fgets($this->fhandle, 1024)) {
            $lineArr = $this->make_array($lineStr);
            if ($lineArr[$column] != $query_string) {
                $newFile .= trim($lineStr)."\n";
            }
        }
        $this->ctb_fclose();
        $this->null_write($newFile);
    }

    //取得一个文件里某个字段的最大值
    function get_max_value($column) {
        if (!file_exists($this->file) or !filesize($this->file)) {
            return 0;
        }
        $fileArr = $this->read_file();
        foreach ($fileArr as $lineStr) {
            $lineArr = $this->make_array($lineStr);
            $valueArr[] = $lineArr[$column];
        }
        return max($valueArr);
    }

    //根据数据文件的某个字段是否包含$query_string进行查询,以二维数组返回所有符合条件的数据
    function select($column, $query_string) {
        $fileArr2 = $this->openfile();
        foreach ($fileArr2 as $lineArr) {
            if ($lineArr[$column] == $query_string) {
                $returnArr[] = $lineArr;
            }
        }
        return $returnArr;
    }

    //功能与function select()一样,速度可能略有提升（cx said：注意，返回的是一维数组！）
    function select2($column, $query_string) {
        $fileArr = $this->read_file();
        foreach ($fileArr as $lineStr) {
            $lineArr = $this->make_array($lineStr);
            if ($lineArr[$column] == $query_string) {
                $returnArr[] = $lineStr;
            }
        }
        return $returnArr;
    }

    //根据数据文件的某个字段是否包含$query_string进行查询,以二维数组返回第一个符合条件的字串数据
    function select_line($column, $query_string) {
        $fileArr = $this->read_file();
        foreach ($fileArr as $lineStr) {
            $lineArr = $this->make_array($lineStr);
            if ($lineArr[$column] == $query_string) {
                return $lineArr;
            }
        }
    }

    //根据数据文件的某个字段是否包含$query_string进行查询, 以二维数组返回第一个符合条件行的前一/后一行字串 by cx
    //$next_prev ==> next/后一/向上, prev/前一/向下
    //返回 0 则没找到前一/后一行
    function select_next_prev_line($column, $query_string, $next_prev) {
		$fileArr = $this->read_file();
		if ($this->linesCnt[$this->file] == 1) {//只有一行
			return 0;
		}
		$lineArr = $this->make_array($fileArr[0]);
		if ($lineArr[$column] == $query_string) {//第一行，lucky :)
			if ($next_prev == 'next') {//no next!
				return 0;
			}
			elseif ($next_prev == 'prev') {
				return $this->make_array(next($fileArr));
			}
		}
		else {
			for ($i=1; $i<$this->linesCnt[$this->file]; $i++) {
				$lineArr = $this->make_array(next($fileArr));
				if ($lineArr[$column] == $query_string) {
					if ($next_prev == 'prev') {
						if ($i == $this->linesCnt[$this->file] - 1) {//最末行
							return 0;
						}
						return $this->make_array(next($fileArr));
					}
					elseif ($next_prev == 'next') {
						return $this->make_array(prev($fileArr));
					}
				}
			}
		}
    }

    //打开定长文件，直接定位后写入一行字串覆盖该行 2004-1-8 by cx
    function seek_write($pos, $newLineStr) {
        $this->ctb_fopen('r+', LOCK_EX);
        fseek($this->fhandle, $pos);
        fputs($this->fhandle, $newLineStr);
        $this->ctb_fclose();
    }

    //debug... 2004-1-4 by cx
    function debug($debugStr) {
        if ($this->debugMode == 'hidden') {
            echo '<!-- ' . $debugStr . " -->\n";
        }
        elseif ($this->debugMode == 'show') {
            echo $debugStr . "<br />\n";
        }
    }
}
?>