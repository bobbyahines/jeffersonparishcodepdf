# Jefferson Parish Code PDF Extractor
A small library for extracting PDF versions of the Jefferson Parish
Code of Ordinances into structured and searchable strings.

## Getting Started

### Build the Docker Image
`docker build -f Dockerfile -t bobbyahines/jpcp` .

### Convert PDF Resource to Text Resource

First, place your PDF version of the Jefferson Parish, LA Code of Ordinances
into the `./resources/pdf` directory. The, simply run the `convertPdfToTxt.php`

**In Docker:**  
`docker run -it --rm -v $PWD:/srv bobbyahines/jpcp php convertPdfToTxt.php`  

----

### Export Converted Text File to Pages

**In Docker:**  
`docker run -it --rm -v $PWD:/srv bobbyahines/jpcp php exportPages.php`  

## Text Structure

Document
* Publication Information
* Current Officials
* The Charter
* The Preamble
* Chapter
    * ARTICLE
        * Division
            * SECTION
