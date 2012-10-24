#include "facialRecognition.h"

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

using namespace cv;


vector<LabelImage> trainingImages;

std::vector<Mat> images;
std::vector<int> labels;

void initImages()
{
  // holds images and labels
  // // images for first person

  LabelImage baseImage = LabelImage(1, imread("../Base_de_donnees/old/faceDatabase/s1/1.pgm", CV_LOAD_IMAGE_GRAYSCALE));
  trainingImages.push_back(baseImage);

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




/** @function detectAndDisplay */
int FaceDetecter::detectAndReframe( Mat frame,String pathWrite)
{
  std::vector<Rect> faces;
  Mat frame_gray;
  int ret=SINGLE_FACE_FOUND;

  cvtColor(frame, frame_gray, CV_BGR2GRAY);
  equalizeHist( frame_gray, frame_gray );

  //-- Detect faces
  face_cascade.detectMultiScale( frame_gray, faces, 1.1, 2, 0|CV_HAAR_SCALE_IMAGE, Size(30, 30) );

  if (faces.size()<=0)
    {
      return NO_FACE_FOUND;
    }

  // We now pick the biggest we've found
  unsigned int maxSubscript=0;
  Rect maxFace=faces[0];
  for( unsigned int i = 1; i < faces.size(); i++ )
    {
      // more than one face have been found 
      ret=MANY_FACES_FOUND;
      // comparaison with heights of faces
      if (faces[i].height>maxFace.height)
	{
	  maxFace=faces[i];
	  maxSubscript=i;
	}
    }

  // pick the center of the face
  Point center( maxFace.x + maxFace.width*0.5, maxFace.y + maxFace.height*0.5 );
  ellipse( frame, center, Size( maxFace.width*0.5, maxFace.height*0.5), 0, 0, 360, Scalar( 255, 0, 255 ), 4, 8, 0 );

  Mat faceROI = frame_gray( maxFace );
  imwrite(pathWrite.c_str() ,faceROI); // A JPG FILE IS BEING SAVED
  printf("image written in %s\n",pathWrite.c_str());
  return ret;
}



int main (int argc,char** argv)
{
  // Create a new Fisherfaces model and retain all available Fisherfaces,
  // this is the most common usage of this specific FaceRecognizer:
  //
  // Ptr<FaceRecognizer> model =  createEigenFaceRecognizer();

  // /////////////////////////////////////////////////// 
  // /////////////////////////////////////////////////// train our FaceRecognizer
  // ///////////////////////////////////////////////////

  // initImages();

  // // // This is the common interface to train all of the available cv::FaceRecognizer
  // // // implementations:
  // // //
  // model->train(images, labels);

  // /////////////////////////////////////////////////// 
  // /////////////////////////////////////////////////// test if the following pic belongs
  // /////////////////////////////////////////////////// 

  // Mat imgPerson1 = imread("../Base_de_donnees/old/faceDatabase/s1/7.pgm", CV_LOAD_IMAGE_GRAYSCALE);
  // Mat imgPerson2 = imread("../Base_de_donnees/old/faceDatabase/s2/7.pgm", CV_LOAD_IMAGE_GRAYSCALE);
  // Mat imgPerson3 = imread("../Base_de_donnees/old/faceDatabase/s3/1.pgm", CV_LOAD_IMAGE_GRAYSCALE);	
  // printf("prediction sujet 1\nlabel: %d\nprediction sujet 2\nlabel: %d\n", model->predict(imgPerson1),model->predict(imgPerson2));
  // printf("prediction sujet inconnu (3)\nlabel: %d\n", model->predict(imgPerson3));

  Mat imgPersonJack = imread("../Base_de_donnees/old/jacques/pic1.jpeg", CV_LOAD_IMAGE_COLOR);	

  FaceDetecter detecter;
  int retDetect=detecter.detectAndReframe(imgPersonJack,"testDetect.jpg");
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

  
  return 0;
}
