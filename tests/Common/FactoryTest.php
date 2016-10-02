<?php

namespace NFePHP\NFSe\Tests\Common;

use NFePHP\NFSe\Tests\NFSeTestCase;
use NFePHP\Common\Certificate;
use NFePHP\NFSe\Common\Factory;

class FactoryTest  extends NFSeTestCase
{
    public $factory;
    
    public function __construct()
    {
        parent::__construct();
        $this->factory = new Factory(Certificate::readPfx($this->contentpfx, $this->passwordpfx));
    }
    
    public function testPathSchemes()
    {
        $path = $this->factory->pathSchemes.DIRECTORY_SEPARATOR.'Prodam';
        $condition = is_dir($path);
        $this->assertTrue($condition);
    }
    
    public function testClear()
    {
        $text = '<?xml version="1.0" encoding="utf-8"?>';
        $actual = $this->factory->clear($text);
        $expected = "";
        $this->assertEquals($expected, $actual);
    }
    
    public function testSetAlgorithm()
    {
        $expected = OPENSSL_ALGO_SHA256;
        $this->factory->setSignAlgorithm(OPENSSL_ALGO_SHA256);
        $this->assertEquals($expected, $this->factory->algorithm);
    }
    
    public function testValidar()
    {
        $body = '<PedidoConsultaCNPJ xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.prefeitura.sp.gov.br/nfe"><Cabecalho xmlns="" Versao="1"><CPFCNPJRemetente><CNPJ>08894935000170</CNPJ></CPFCNPJRemetente></Cabecalho><CNPJContribuinte xmlns=""><CNPJ>08894935000170</CNPJ></CNPJContribuinte><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/><Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>hba9T3PJ/pNk/hAq8h91tjifWXA=</DigestValue></Reference></SignedInfo><SignatureValue>d49fmX99sdzLOGJl7KvVjCmFwSmgbkFCbX5xgfFYbVpxq/N8nm9vIV2MKE51i+U5jM2fZhNi7YmUtgE0D5yIKQkKKMkIhODB7w+BK5qgkACM3mTaS+2MaoJRh/8tFXHnFCOCt+Mf365oy79BFzQ+Q+70v2GP9PDDL772CzH1l6YMikrwcRMCIV94AO7e/fyn/mwf7RMtEbHc31q5Y083w8dO+DilkRorltLmF6V3DgYRybo4McOKLmYdpQ//eO5OhR34UiRexG8Ru3sbezT0zrlkCnIm+ma5VE4ibcdCkoPT7z49jfE6YBD8eaQwhuq4a6tqrX4fvDj2pGwUerXnog==</SignatureValue><KeyInfo><X509Data><X509Certificate>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</X509Certificate></X509Data></KeyInfo></Signature></PedidoConsultaCNPJ>';
        $condition = $this->factory->validar(1, $body, 'Prodam', 'PedidoConsultaCNPJ', 'v');
        $this->assertTrue($condition);
    }
    
    /**
     * @expectedException NFePHP\Common\Exception\ValidatorException
     */
    public function testValidarXmlFail()
    {
        $versao = 1;
        $body = '<PedidoConsultaCNPJ xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.prefeitura.sp.gov.br/nfe"><Cabecalho xmlns="" Versao="1"><CPFCNPJRemetente><CNPJ>08894935000170</CNPJ></CPFCNPJRemetente></Cabecalho><CNPJContribuinte xmlns=""></CNPJContribuinte><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/><Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>hba9T3PJ/pNk/hAq8h91tjifWXA=</DigestValue></Reference></SignedInfo><SignatureValue>d49fmX99sdzLOGJl7KvVjCmFwSmgbkFCbX5xgfFYbVpxq/N8nm9vIV2MKE51i+U5jM2fZhNi7YmUtgE0D5yIKQkKKMkIhODB7w+BK5qgkACM3mTaS+2MaoJRh/8tFXHnFCOCt+Mf365oy79BFzQ+Q+70v2GP9PDDL772CzH1l6YMikrwcRMCIV94AO7e/fyn/mwf7RMtEbHc31q5Y083w8dO+DilkRorltLmF6V3DgYRybo4McOKLmYdpQ//eO5OhR34UiRexG8Ru3sbezT0zrlkCnIm+ma5VE4ibcdCkoPT7z49jfE6YBD8eaQwhuq4a6tqrX4fvDj2pGwUerXnog==</SignatureValue><KeyInfo><X509Data><X509Certificate>MIIIDDCCBfSgAwIBAgIIEmk3uzWy2H0wDQYJKoZIhvcNAQELBQAwdTELMAkGA1UEBhMCQlIxEzARBgNVBAoTCklDUC1CcmFzaWwxNjA0BgNVBAsTLVNlY3JldGFyaWEgZGEgUmVjZWl0YSBGZWRlcmFsIGRvIEJyYXNpbCAtIFJGQjEZMBcGA1UEAxMQQUMgU0VSQVNBIFJGQiB2MjAeFw0xNjA3MjcxMjU1MDBaFw0xNzA3MjcxMjU1MDBaMIHyMQswCQYDVQQGEwJCUjELMAkGA1UECBMCU1AxEjAQBgNVBAcTCVNBTyBQQVVMTzETMBEGA1UEChMKSUNQLUJyYXNpbDE2MDQGA1UECxMtU2VjcmV0YXJpYSBkYSBSZWNlaXRhIEZlZGVyYWwgZG8gQnJhc2lsIC0gUkZCMRYwFAYDVQQLEw1SRkIgZS1DTlBKIEExMRIwEAYDVQQLEwlBUiBTRVJBU0ExSTBHBgNVBAMTQElOTk9WQSBQUklNRSBDT01FUkNJTyBERSBQQUlORUlTIEUgU0VSVklDT1MgREUgQ086MDg4OTQ5MzUwMDAxNzAwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCTakIEBDTehKNb+Cf9TAMmkkKDw81aFpUjc0tL9D7AqT1temQJw3kVE8gFtIbNoGNfnQ6NE1/i4jYSCn8sbJ0RYBTLh17kfU0GidlGVrDH0DiUaOG87DjBpkDPLkUPEbFPy59kaaEwyvBtlzz+VOjWElOrzjMB5mZXszRrUwt/20z11lCqs7SFUqAujGW0t3jkyEV9Hc2MVU1O9Bhb/omUGJl83Fsd3fW/qzqkAxvi1L5OCcbbI2mlyzmF210dIXqsoFfelvoy2+bHx1dEWmtkmLQ927dqd+zsUeNd0D7P9ro5dE6qRbKarFEuptyCVVG5WFL5leTYEARV+AepONTVAgMBAAGjggMgMIIDHDCBmQYIKwYBBQUHAQEEgYwwgYkwSAYIKwYBBQUHMAKGPGh0dHA6Ly93d3cuY2VydGlmaWNhZG9kaWdpdGFsLmNvbS5ici9jYWRlaWFzL3NlcmFzYXJmYnYyLnA3YjA9BggrBgEFBQcwAYYxaHR0cDovL29jc3AuY2VydGlmaWNhZG9kaWdpdGFsLmNvbS5ici9zZXJhc2FyZmJ2MjAJBgNVHRMEAjAAMB8GA1UdIwQYMBaAFLKgxD1GnnzIhWwIHhAylGVGcEFzMHEGA1UdIARqMGgwZgYGYEwBAgENMFwwWgYIKwYBBQUHAgEWTmh0dHA6Ly9wdWJsaWNhY2FvLmNlcnRpZmljYWRvZGlnaXRhbC5jb20uYnIvcmVwb3NpdG9yaW8vZHBjL2RlY2xhcmFjYW8tcmZiLnBkZjCB8wYDVR0fBIHrMIHoMEqgSKBGhkRodHRwOi8vd3d3LmNlcnRpZmljYWRvZGlnaXRhbC5jb20uYnIvcmVwb3NpdG9yaW8vbGNyL3NlcmFzYXJmYnYyLmNybDBEoEKgQIY+aHR0cDovL2xjci5jZXJ0aWZpY2Fkb3MuY29tLmJyL3JlcG9zaXRvcmlvL2xjci9zZXJhc2FyZmJ2Mi5jcmwwVKBSoFCGTmh0dHA6Ly9yZXBvc2l0b3Jpby5pY3BicmFzaWwuZ292LmJyL2xjci9TZXJhc2EvcmVwb3NpdG9yaW8vbGNyL3NlcmFzYXJmYnYyLmNybDAOBgNVHQ8BAf8EBAMCBeAwHQYDVR0lBBYwFAYIKwYBBQUHAwIGCCsGAQUFBwMEMIG5BgNVHREEgbEwga6BGVNBTkRSQUBJTk5PVkFQUklNRS5DT00uQlKgIwYFYEwBAwKgGhMYRkFCSUFOQSBNQVJJQSBDQVZBTENBTlRFoBkGBWBMAQMDoBATDjA4ODk0OTM1MDAwMTcwoDgGBWBMAQMEoC8TLTE0MDkxOTgzMzA5MzQwNTA4NDgwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMKAXBgVgTAEDB6AOEwwwMDAwMDAwMDAwMDAwDQYJKoZIhvcNAQELBQADggIBALVIY5zIU+LMZSDFNnAY991mKxhZLXq5CJCjWw0mtQsQlgThAKhHw9hvKkkwifqHOCxQw4GiRxoJoujRRgc6lBKvnTNwOLT1xlrfiNu7IA4qayKQd7CjQHOZsInNwjRzP+XlSg5z6Ww72dQpinRVh5jPAIY3fkxT+i1JdC/Dqa1tMAvFFJh4+1J8mvI8UERZv52lF8/jCrmcur0nOxXyO4+4P8KEFRkaxQtPewqnGxCQJoAkAG7vozcziaiuKxptM3ll7j8Y6nO1TTebeKXzCiSMlbJcYr+IsGrxABV1hBSw2Uy9xK4JI6VQHwLMnSAltZZnRPX3T0TqSX7B0HgPJSfUvG7se2m8QWbZBY17tA8EqmEAeAIhzp4Gpc84VfPMh78ALStA9jhldE6huTbdfbiWL4Yi8GgzUPNJ0pFXat927G15KJpaRTo/YyZeVuxJ/xe5697vPCI4jmCy4I00fyFqKYsG9t2FM7N/QGcgHycC+CATx0BJUCQ/vlLKW/swrjAJRqtwEgt2aBxpuHWU2TP2feonE0IQiJoR3CWZ2Dp8lYqd5umtiIewd+Cb037Pz5hW7RXEi0DIHydY4zYWDnhTQzzYrzhJ5ED0CNGkVYPg0lXao2u03vC8C8vTzrRnX+WRibMngzPKH4rzQ9dqCbUmwhY0GP0lXn0KI8PVts2Z</X509Certificate></X509Data></KeyInfo></Signature></PedidoConsultaCNPJ>';
        $condition = $this->factory->validar($versao, $body, 'Prodam', 'PedidoConsultaCNPJ', 'v');
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testValidarXsdFail()
    {
        $versao = 99;
        $body = '<PedidoConsultaCNPJ xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.prefeitura.sp.gov.br/nfe"><Cabecalho xmlns="" Versao="1"><CPFCNPJRemetente><CNPJ>08894935000170</CNPJ></CPFCNPJRemetente></Cabecalho><CNPJContribuinte xmlns=""><CNPJ>08894935000170</CNPJ></CNPJContribuinte><Signature xmlns="http://www.w3.org/2000/09/xmldsig#"><SignedInfo><CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/><SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1"/><Reference URI=""><Transforms><Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature"/><Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315"/></Transforms><DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><DigestValue>hba9T3PJ/pNk/hAq8h91tjifWXA=</DigestValue></Reference></SignedInfo><SignatureValue>d49fmX99sdzLOGJl7KvVjCmFwSmgbkFCbX5xgfFYbVpxq/N8nm9vIV2MKE51i+U5jM2fZhNi7YmUtgE0D5yIKQkKKMkIhODB7w+BK5qgkACM3mTaS+2MaoJRh/8tFXHnFCOCt+Mf365oy79BFzQ+Q+70v2GP9PDDL772CzH1l6YMikrwcRMCIV94AO7e/fyn/mwf7RMtEbHc31q5Y083w8dO+DilkRorltLmF6V3DgYRybo4McOKLmYdpQ//eO5OhR34UiRexG8Ru3sbezT0zrlkCnIm+ma5VE4ibcdCkoPT7z49jfE6YBD8eaQwhuq4a6tqrX4fvDj2pGwUerXnog==</SignatureValue><KeyInfo><X509Data><X509Certificate>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</X509Certificate></X509Data></KeyInfo></Signature></PedidoConsultaCNPJ>';
        $condition = $this->factory->validar($versao, $body, 'Prodam', 'PedidoConsultaCNPJ', 'v');
    }
}
