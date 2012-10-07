#include "facialRecognition.h"
#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

using namespace cv;

int main (int argc,char** argv)
{
  // Create a new Fisherfaces model and retain all available Fisherfaces,
  // this is the most common usage of this specific FaceRecognizer:
  //
  Ptr<FaceRecognizer> model =  createEigenFaceRecognizer();

  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// train our FaceRecognizer
  /////////////////////////////////////////////////// 
  // holds images and labels
  vector<Mat> images;
  vector<int> labels;
  // // images for first person
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
  // // This is the common interface to train all of the available cv::FaceRecognizer
  // // implementations:
  // //
  model->train(images, labels);

  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// test if the following pic belongs
  /////////////////////////////////////////////////// 

  Mat imgPerson1 = imread("../Base_de_donnees/faceDatabase/s1/7.pgm", CV_LOAD_IMAGE_GRAYSCALE);
  Mat imgPerson2 = imread("../Base_de_donnees/faceDatabase/s2/7.pgm", CV_LOAD_IMAGE_GRAYSCALE);

  printf("prediction sujet 1\nlabel: %d\nprediction sujet 2\nlabel: %d\n", model->predict(imgPerson1),model->predict(imgPerson2));
  
  return 0;
}
