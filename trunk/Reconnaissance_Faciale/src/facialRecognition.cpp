#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

#include <iostream>
#include <iomanip>
#include <locale>
#include <sstream>
#include <string> 

#include "facialRecognition.h"
#include "faceDetecter.h"
#include "labelImage.h"


using namespace cv;


vector<LabelImage> trainingImages;

std::vector<Mat> images;
std::vector<int> labels;

void initImages()
{
  // holds images and labels
  // // images for first person

  string numDirectory;
  string numImage;
  string imgString;

  for(int i = 1; i < 3; i++)
    {

      for(int j = 1; j < 7; j++)
	{
	  //numImage = "";
	  std::stringstream outI;
	  std::stringstream outJ;

	  outI << i;
	  numDirectory = outI.str();
	  numDirectory += "/";

	  outJ << j;
	  numImage = outJ.str();
	  numImage += ".pgm";

	  printf("../Base_de_donnees/old/faceDatabase/s%s%s\n", numDirectory.c_str(), numImage.c_str());

	  imgString = "../Base_de_donnees/old/faceDatabase/s"+ numDirectory + numImage;

	  baseImage = LabelImage(i, imread(imgString, CV_LOAD_IMAGE_GRAYSCALE));
	  trainingImages.push_back(baseImage);
	}
    }

  //trainingImages
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s1/1.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s1/2.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s1/3.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s1/4.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s1/5.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s1/6.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);

  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s2/1.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s2/2.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s2/3.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s2/4.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s2/5.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
  images.push_back(imread("../Base_de_donnees/old/faceDatabase/s2/6.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
}




int whois (Mat personToPredict)
{
  Ptr<FaceRecognizer> model =  createEigenFaceRecognizer();
  Create a new Fisherfaces model and retain all available Fisherfaces,
  this is the most common usage of this specific FaceRecognizer:
  

  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// train our FaceRecognizer
  ///////////////////////////////////////////////////

  initImages();

  // // This is the common interface to train all of the available cv::FaceRecognizer
  // // implementations:
  // //
  model->train(images, labels);

  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// test if the following pic belongs
  /////////////////////////////////////////////////// 

  return model->predict(personToPredict);
}


int main (int argc,char** argv)
{
  if(argc<1)
    {
      printf("Please specify an argument:\n1 for face recognition\n2 reframe image\n");
      exit(-1);
    }
  switch(atoi(argv[1]))
    {
    case (1):
      {
	Mat imgPersonJack = imread("../Base_de_donnees/old/jacques/pic1.jpeg", CV_LOAD_IMAGE_COLOR);	
	return whois(imgPersonJack);
      }
      break;
    case (2):
      {
	Mat imgPersonJack = imread("../Base_de_donnees/old/jacques/pic1.jpeg", CV_LOAD_IMAGE_COLOR);	
	Mat imgPersonJackReframed;
	int retDetect=detecter.detectAndReframe(imgPersonJack,imgPersonJackReframed);
	switch(retDetect)
	  {
	  case MANY_FACES_FOUND:
	    {
	      printf("many faces have been found on the image given, we took the heighest\n");
	    }
	    break;
	  case SINGLE_FACE_FOUND:
	    {
	      printf("just one face has been found on the image\n");
	    }
	    break;
	  case NO_FACE_FOUND:
	    {
	      printf("no face has been found on the image\n");
	    }
	    break;
	  }
	imwrite("testDetect.jpg",imgPersonJackReframed);
      }

  
  return 0;
}
