#ifndef FACIALRECOGNITION_H
#define FACIALRECOGNITION_H

#include <iostream>
#include <string>

#include "opencv/cv.h"
#include "opencv/cvwimage.h"
#include "opencv/cvaux.h"
#include "opencv/cxcore.h"
#include "opencv/cxmisc.h"
#include "opencv/highgui.h"
#include "opencv/ml.h"

#include "labelImage.h"



class RecognizerOfFace
{
 private:
  std::vector<cv::Mat> images;
  std::vector<int> labels;
 public:
  inline RecognizerOfFace():
  threshold(10.)
    {}
  inline RecognizerOfFace(double limit):
    threshold(limit)
  {}
  double threshold;
  void initImages();
  void whois (cv::Mat personToPredict,int &label,double &confidence);
  void flush();
};


#endif
