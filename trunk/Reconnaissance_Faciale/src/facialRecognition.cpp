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

class LabelImage
{
private:
	int ID;
	Mat image;

public:
 LabelImage(int otherID, Mat otherImage)
	{
		ID = otherID;
		image = otherImage;
	}

	int GetID()
	{
		return ID;
	}

	Mat GetImage()
	{
		return image;
	}
};

vector<LabelImage> trainingImages;


vector<Mat> images;
vector<int> labels;

void initImages()
{
	// holds images and labels
	// // images for first person

	LabelImage baseImage = LabelImage(1, imread("../Base_de_donnees/faceDatabase/s1/1.pgm", CV_LOAD_IMAGE_GRAYSCALE));
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

			printf("../Base_de_donnees/faceDatabase/s%s%s\n", numDirectory.c_str(), numImage.c_str());

			imgString = "../Base_de_donnees/faceDatabase/s"+ numDirectory + numImage;

			baseImage = LabelImage(i, imread(imgString, CV_LOAD_IMAGE_GRAYSCALE));
			trainingImages.push_back(baseImage);
		}
	}

	//trainingImages
	images.push_back(imread("../Base_de_donnees/faceDatabase/s1/1.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s1/2.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s1/3.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s1/4.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s1/5.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s1/6.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);

	images.push_back(imread("../Base_de_donnees/faceDatabase/s2/1.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s2/2.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s2/3.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s2/4.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s2/5.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
	images.push_back(imread("../Base_de_donnees/faceDatabase/s2/6.pgm", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(2);
}




 /** Global variables */
 String face_cascade_name = "OpenCV-2.4.2/data/haarcascades/haarcascade_frontalface_alt.xml";
 String eyes_cascade_name = "OpenCV-2.4.2/data/haarcascades/haarcascade_eye_tree_eyeglasses.xml";
 CascadeClassifier face_cascade;
 CascadeClassifier eyes_cascade;
 RNG rng(12345);

/** @function detectAndDisplay */
void detectAndDisplay( Mat frame )
{
  std::vector<Rect> faces;
  Mat frame_gray;

  cvtColor( frame, frame_gray, CV_BGR2GRAY );
  equalizeHist( frame_gray, frame_gray );

  //-- Detect faces
  face_cascade.detectMultiScale( frame_gray, faces, 1.1, 2, 0|CV_HAAR_SCALE_IMAGE, Size(30, 30) );

  for( int i = 0; i < faces.size(); i++ )
    {
      Point center( faces[i].x + faces[i].width*0.5, faces[i].y + faces[i].height*0.5 );
      ellipse( frame, center, Size( faces[i].width*0.5, faces[i].height*0.5), 0, 0, 360, Scalar( 255, 0, 255 ), 4, 8, 0 );

      Mat faceROI = frame_gray( faces[i] );
      imwrite("test.jpg" ,faceROI); // A JPG FILE IS BEING SAVED
      std::vector<Rect> eyes;

      //-- In each face, detect eyes
      eyes_cascade.detectMultiScale( faceROI, eyes, 1.1, 2, 0 |CV_HAAR_SCALE_IMAGE, Size(30, 30) );

      for( int j = 0; j < eyes.size(); j++ )
	{
	  Point center( faces[i].x + eyes[j].x + eyes[j].width*0.5, faces[i].y + eyes[j].y + eyes[j].height*0.5 );
	  int radius = cvRound( (eyes[j].width + eyes[j].height)*0.25 );
	  circle( frame, center, radius, Scalar( 255, 0, 0 ), 4, 8, 0 );
	}
    }
  //-- Show what you got
  // imwrite("test.jpg" ,frame); // A JPG FILE IS BEING SAVED
  // OF 6KB , BUT IT IS BLACK

  // imshow( window_name, frame );
}

int main (int argc,char** argv)
{
  // Create a new Fisherfaces model and retain all available Fisherfaces,
  // this is the most common usage of this specific FaceRecognizer:
  //
  Ptr<FaceRecognizer> model =  createEigenFaceRecognizer();

  //-- 1. Load the cascades
  if( !face_cascade.load( face_cascade_name ) ){ printf("--(!)Error loading\n"); return -1; };
  if( !eyes_cascade.load( eyes_cascade_name ) ){ printf("--(!)Error loading\n"); return -1; };

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

  Mat imgPerson1 = imread("../Base_de_donnees/faceDatabase/s1/7.pgm", CV_LOAD_IMAGE_GRAYSCALE);
  Mat imgPerson2 = imread("../Base_de_donnees/faceDatabase/s2/7.pgm", CV_LOAD_IMAGE_GRAYSCALE);
  Mat imgPerson3 = imread("../Base_de_donnees/faceDatabase/s3/1.pgm", CV_LOAD_IMAGE_GRAYSCALE);	
  Mat imgPersonJack = imread("../Base_de_donnees/jacques/pic0.jpeg", CV_LOAD_IMAGE_COLOR);	
  detectAndDisplay(imgPersonJack);

  printf("prediction sujet 1\nlabel: %d\nprediction sujet 2\nlabel: %d\n", model->predict(imgPerson1),model->predict(imgPerson2));
  printf("prediction sujet inconnu (3)\nlabel: %d\n", model->predict(imgPerson3));
  
  return 0;
}
