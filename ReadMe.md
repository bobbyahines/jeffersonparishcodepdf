# Jefferson Parish Code PDF to Markdown Site
Takes in the PDF Resource, and exports the Charter in Markdown, currently divided by Chapter. The intention is for use
in a static site generator. The Markdown is informed by the document's natural structure:

* The Charter                   (#)
  * Preamble                    (##)
    * Article [arabic numerals] (###)
      * Division                (####)
        * Section               (#####) 
  * Chapter                                  (##)
    * Article [roman numerals] (optional)    (###)
      * Division (optional)                  (####)
        * Sec.                               (#####)

## Getting Started

1. Download this repository to your local development computer.

2. Run composer install:
  `docker run -it --rm -v $PWD:/app library/composer:latest install`

3. Load the PDF:  
  Place your PDF version of the Jefferson Parish, LA Code of Ordinances into the 
  `./resources/pdf` directory.
   
4. Build the Docker image:  
  `docker build -f Dockerfile -t bobbyahines/jpcp` .  

5. Covert the PDF to a Markdown Resource:  
  `docker run -it --rm -v $PWD:/srv bobbyahines/jpcp php run.php`  

6. Host the static site:
  `docker run -it --rm -v $PWD/docs:/docs -p "80:8000" squidfunk/mkdocs-material`

## Document Structure
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

## Run Unit Tests

Unit tests are present in the `tests/` folder. Currently they are just scaffolding.

**In Docker:**
`docker run -it --rm -v $PWD:/srv bobbyahines/jpcp phpunit`
