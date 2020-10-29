# Jefferson Parish Code PDF Extractor
A small library for extracting PDF versions of the Jefferson Parish
Code of Ordinances into structured and searchable strings.

## Getting Started

1. Load the PDF:  
  Place your PDF version of the Jefferson Parish, LA Code of Ordinances into the 
  `./resources/pdf` directory.
   
2. Build the Docker image:  
  `docker build -f Dockerfile -t bobbyahines/jpcp` .  

3. Covert the PDF to a TXT Resource:  
  `docker run -it --rm -v $PWD:/srv bobbyahines/jpcp php convertPdfToTxt.php`  

With the pdf converted to text, regular expressions become available for parsing.
Several options are currently included:

### exportPages.php
Export Converted Text File to Pages: `php exportPages.php`

**In Docker:**  
`docker run -it --rm -v $PWD:/srv bobbyahines/jpcp php exportPages.php`  

### exportStructured.php  
Export a structured group of text files informed by the document's natural structure:

* Volume
* Current Officials
* Preface
  * Numbering System
  * Page Numbering System
  * Indices
  * Looseleaf Supplements
  * Acknowledgments
* Ordinance of Adoption
  * Summary No.
  * Ordinance No.
* Supplemental History Table
* The Charter                   (#)
  * Preamble                    (##)
    * Article [arabic numerals] (###)
      * Division                (####)
        * Section               (#####) 
  * Chapter                                  (##)
    * Article [roman numerals] (optional)    (###)
      * Division (optional)                  (####)
        * Sec.                               (#####)

**In Docker:**  
`docker run -it --rm -v $PWD:/srv bobbyahines/jpcp php exportStructured.php`  

## Run Unit Tests

Unit tests are present in the `tests/` folder. Currently they are just scaffolding.

**In Docker:**
`docker run -it --rm -v $PWD:/srv bobbyahines/jpcp phpunit`
