<?php

date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$hora = date('H:i:s');
ini_set("session.auto_start", 0);
//fazemos a inclusão do arquivo com a classe FPDF
require_once("fpdf.php");
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PdfCustomizado extends FPDF {

//Page header
    function Header() {

      //Logo
        $this->Image('../../imagens/logo-governo.png', 25, 10, 50);
//Arial bold 15
        $this->SetFont('Arial', 'B', 15);
//Move to the right
        $this->Cell(95, 10, '', 0, 0);
        $this->SetFont('arial', 'B', 9);
        $this->Cell(0, 1, utf8_decode('Secretaria de Estado de Ciência Tecnologia e'), 0, 1);
        $this->Cell(0, 1, '', 0, 1);
        $this->Cell(95, 4, '', 0, 0);
        $this->SetFont('arial', 'B', 9);
        $this->Cell(95, 6, 'Ensino Superior de Minas Gerais', 0, 1);
        $this->Cell(95, 4, '', 0, 0);
        $this->SetFont('Times', '', 9, 5);
        $this->Cell(19, 6, 'Rodovia Prefeito Americo Gianetti, s/n', 0, 0);
        $this->Cell(50, 0, '', 0, 1, "L");
        $this->Cell(50, 0, '', 0, 1, "L");
        $this->Cell(95, 0, '', 0, 0, "L");
        $this->Cell(30, 12, 'Bairro Serra Verde - CEP 31.630-901', 0, 0, "L");
        $this->Cell(50, 0, '', 0, 1, "L");
        $this->Cell(220, 0, '', 0, 0, "L");
        $this->Cell(50, 0, '', 0, 1, "L");
        $this->Cell(95, 0, '', 0, 0, "L");
        $this->Cell(30, 18, 'Belo Horizonte -  Minas Gerais', 0, 0, "L");
        $this->Cell(50, 0, '', 0, 1, "L");
        $this->Cell(220, 0, '', 0, 0, "L");
        $this->Cell(50, 0, '', 0, 1, "L");
        $this->Cell(95, 0, '', 0, 0, "L");
        $this->Cell(30, 24, 'CNPJ  19.377.514/0001-99', 0, 1, "L");
        $this->Ln(10);
       

        //Line break
    }

//Page footer
    function Footer() {
        //Position at 1.5 cm from bottom
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial', 'B', 6);
        //Page number
        $this->Cell(0, 1, utf8_decode('Guia de Produtos  /        ' . $data = date('d/m/Y')), 0, 1);

        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

}