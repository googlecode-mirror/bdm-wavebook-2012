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




int main (int argc,char** argv)
{
  // Create a new Fisherfaces model and retain all available Fisherfaces,
  // this is the most common usage of this specific FaceRecognizer:
  //
  Ptr<FaceRecognizer> model =  createEigenFaceRecognizer();

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

  printf("prediction sujet 1\nlabel: %d\nprediction sujet 2\nlabel: %d\n", model->predict(imgPerson1),model->predict(imgPerson2));
  printf("prediction sujet inconnu (3)\nlabel: %d\n", model->predict(imgPerson3));
  
  return 0;
}
