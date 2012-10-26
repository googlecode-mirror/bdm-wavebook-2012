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

class FacialRecognition
{
 private:
  /// the database of faces
  /// should match the real  (ROM) database
  std::vector<LabelImage> dataBase;

 public:
  FacialRecognition();
  ~FacialRecognition();

  /** 
   * read from ROM database and load images/labels into vector database (RAM)
   * this function should be called once
   *
   */
  void initDatabase ();

  /** 
   * given a person's name, this function looks for that guy in the database and load
   * it into its vector (RAM). It creates a new label for him.
   * 
   * @param personName 
   * 
   * @return code that indicate if the person has been found
   */
  int readPersonFromDatabase(std::string personName);

  /** 
   * Discard a label such that we don't try to match a given face to the labeled person anymore.
   * This function might be useful later on for speeding up the algorithm using heuristics.
   * DO NOT REMOVE THE LABELED PERSON FROM THE DATABASE
   */
  void discardLabel (int label);
  /** 
   * Opposite of discard: if the label was discarded in database then it won't be anymore.
   * 
   */
  void keepLabel (int label);

  /** 
   * given a well formated image of a face, this function check whether the guy on the picture is
   * in the database. It returns the label of this guy if he is, or -1 otherwise.
   * 
   * @param img the image of the face to test
   * 
   * @return the label of the person, or -1 if not in database
   */
  int isInDatabase (cv::Mat img);
};


#endif
