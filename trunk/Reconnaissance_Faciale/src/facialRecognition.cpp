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
  Ptr<FaceRecognizer> model =  createFisherFaceRecognizer();

  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// train our FaceRecognizer
  /////////////////////////////////////////////////// 
  // holds images and labels
  vector<Mat> images;
  vector<int> labels;
  // images for first person
  images.push_back(imread("../Base_de_donnees/pic0.jpeg", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/pic1.jpeg", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/pic2.jpeg", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/pic3.jpeg", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/pic4.jpeg", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  images.push_back(imread("../Base_de_donnees/pic5.jpeg", CV_LOAD_IMAGE_GRAYSCALE)); labels.push_back(1);
  // This is the common interface to train all of the available cv::FaceRecognizer
  // implementations:
  //
  model->train(images, labels);

  /////////////////////////////////////////////////// 
  /////////////////////////////////////////////////// test if the following pic belongs
  /////////////////////////////////////////////////// 

  Mat img = imread("../Base_de_donnees/pic6.jpeg", CV_LOAD_IMAGE_GRAYSCALE);
  int predicted_label=model->predict(img);
  printf("label: %d\n",predicted_label);
  return 0;
}
